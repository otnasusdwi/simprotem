<?php
namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Harga;
use App\Models\HargaKulakanMonitoring;
use App\Models\HargaMonitoring;
use App\Models\HasilMonitoring;
use App\Models\ItemLaporan;
use App\Models\ItemMonitoring;
use App\Models\Laporan;
use App\Models\Monitoring;
use App\Models\Tipe;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PDF;
use Ramsey\Uuid\Uuid;
use Response;

class AdminHomeController extends Controller
{
    private function authorizeReportManagement(): void
    {
        abort_unless(Auth::check() && in_array((string) Auth::user()->level, ['2', '3'], true), 403);
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d', 'required_with:to'],
            'to' => ['nullable', 'date_format:Y-m-d', 'required_with:from', 'after_or_equal:from'],
            'id_user' => ['nullable', 'integer', 'exists:users,id'],
            'id_tipe' => ['nullable', 'integer', 'exists:tipe,id_tipe'],
        ]);

        $id_user = $validated['id_user'] ?? null;
        $id_tipe = $validated['id_tipe'] ?? null;
        $from = $validated['from'] ?? Carbon::now()->subDays(2)->format('Y-m-d');
        $to = $validated['to'] ?? Carbon::now()->format('Y-m-d');

        if ($id_user && $id_tipe && ! User::whereKey($id_user)->where('role', 'sales')->where('tipe', $id_tipe)->exists()) {
            throw ValidationException::withMessages([
                'id_user' => 'Sales yang dipilih tidak termasuk dalam tipe tersebut.',
            ]);
        }

        $get = (object) [
            'from' => $from,
            'to' => $to,
            'id_user' => $id_user,
            'id_tipe' => $id_tipe,
        ];

        $q = Laporan::join('users', 'laporan.id_user', '=', 'users.id')
            ->leftJoin('tipe', 'laporan.id_tipe', '=', 'tipe.id_tipe')
            ->select('laporan.*', 'users.name', 'users.piutang as piutang_sales', 'tipe.tipe as nama_tipe')
            ->whereBetween('laporan.tgl_laporan', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ]);

        if ($id_user) {
            $q->where('laporan.id_user', $id_user);
        }

        if ($id_tipe) {
            $q->where('laporan.id_tipe', $id_tipe);
        }

        $setoran = (clone $q)->sum('laporan.setoran');
        $data = $q->orderBy('laporan.created_at', 'desc')->get();

        $sales = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('role', 'sales')
            ->get();
        $salesOptions = $sales->map(fn ($salesUser) => [
            'id' => (string) $salesUser->id,
            'name' => $salesUser->name,
            'tipe' => (string) $salesUser->tipe,
        ])->values();

        $tipe = DB::table('tipe')
            ->orderBy('tipe', 'asc')
            ->get();

        // dd($setoran);

        return view('admin.laporan.read')->with([
            'data' => $data,
            'sales' => $sales,
            'salesOptions' => $salesOptions,
            'tipe' => $tipe,
            'get' => $get,
            'setoran' => $setoran,
        ]);
    }

    public function getSales($id_tipe)
    {
        if ($id_tipe == 0) {
            $data = User::where('role', 'sales')->orderBy('name', 'ASC')->get(['id', 'name', 'tipe']);
        } else {
            $data = User::where('role', 'sales')->where('tipe', $id_tipe)->orderBy('name', 'ASC')->get(['id', 'name', 'tipe']);
        }

        return response()->json($data);
    }

    public function transaksi(Request $request)
    {
        $created_at = $request->created_at;

        $get = (object) [
            'created_at' => $request->created_at,
        ];

        if ($created_at) {
            $data = DB::table('laporan')
                ->join('users', 'laporan.id_user', '=', 'users.id')
                ->select('laporan.*', 'users.name', 'users.piutang')
                ->whereDate('laporan.created_at', '=', $created_at)
                ->orderBy('laporan.tgl_laporan', 'desc')
                ->get();

            $saldo = DB::table('laporan')
                ->whereDate('laporan.created_at', '=', $created_at)
                ->orderBy('laporan.tgl_laporan', 'desc')
                ->sum('setoran');
        } else {
            $data  = [];
            $saldo = 0;
        }

        return view('admin.transaksi.read')->with(['data' => $data, 'saldo' => $saldo, 'get' => $get]);
    }

    public function monitoring(Request $request)
    {
        $query = DB::table('monitoring')->orderBy('tgl_laporan', 'desc');

        // Filter by date range if provided
        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from');
            $to   = $request->input('to');
            $query->whereBetween('tgl_laporan', [$from, $to]);
        } else {
            $query->whereMonth('tgl_laporan', date('m'))
                ->whereYear('tgl_laporan', date('Y'));
        }

        $data = $query->get();

        $sales = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('role', 'sales')
            ->get();

        $tipe = DB::table('tipe')
            ->orderBy('tipe', 'asc')
            ->get();

        return view('admin.monitoring.read', [
            'data'  => $data,
            'sales' => $sales,
            'tipe'  => $tipe,
        ]);
    }

    public function create_monitoring(Request $request)
    {
        $harga = DB::table('harga')
            ->where('id_tipe', 1)
            ->orderBy('harga', 'desc')
            ->get();

        $users = DB::table('users')
            ->where('role', '=', 'sales')
            ->orderBy('tipe', 'asc')
            ->get();

        return view('admin.monitoring.create')->with(['users' => $users, 'harga' => $harga]);
    }

    public function create_rendaman($id_monitoring)
    {
        $monitoring = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();
        return view('admin.monitoring.rendaman')->with(['monitoring' => $monitoring, 'id_monitoring' => $id_monitoring]);
    }

    public function update_rendaman(Request $request)
    {
        // dd($request);

        $id_monitoring = $request->id_monitoring;
        $rendaman      = $request->rendaman;

        DB::table('monitoring')->where('id_monitoring', $id_monitoring)->update(['rendaman' => $rendaman]);

        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function edit_monitoring($id_monitoring)
    {
        $monitoring  = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();
        $tgl_laporan = $monitoring->tgl_laporan;

        $harga = DB::table('harga')
            ->where('id_tipe', 1)
            ->orderBy('harga', 'desc')
            ->get();

        $users = DB::table('users')
            ->where('role', '=', 'sales')
            ->orderBy('tipe', 'asc')
            ->get();

        $item_monitoring = DB::table('item_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        return view('admin.monitoring.edit')->with(['users' => $users, 'harga' => $harga, 'item_monitoring' => $item_monitoring, 'id_monitoring' => $id_monitoring, 'tgl_laporan' => $tgl_laporan]);
    }

    public function sisa_monitoring(Request $request)
    {
        $id_monitoring = $request->id_monitoring;

        $monitoring  = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();
        $tgl_laporan = $monitoring->tgl_laporan;

        $harga = DB::table('harga')
            ->where('id_tipe', 1)
            ->orderBy('harga', 'desc')
            ->get();

        $users = DB::table('users')
            ->where('role', '=', 'sales')
            ->orderBy('tipe', 'asc')
            ->get();

        $item_monitoring = DB::table('item_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        $tgl = Carbon::parse($tgl_laporan)->translatedFormat('l, d F Y');

        return view('admin.monitoring.sisa')->with(['users' => $users, 'harga' => $harga, 'id_monitoring' => $id_monitoring, 'tgl_laporan' => $tgl_laporan, 'tgl' => $tgl, 'item_monitoring' => $item_monitoring]);
    }

    public function tambah_monitoring(Request $request)
    {
        $id_monitoring = $request->id_monitoring;

        $monitoring = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();

        $tgl_laporan = $monitoring->tgl_laporan;

        $harga = DB::table('harga')
            ->where('id_tipe', 1)
            ->orderBy('harga', 'desc')
            ->get();

        $users = DB::table('users')
            ->where('role', '=', 'sales')
            ->orderBy('tipe', 'asc')
            ->get();

        $item_monitoring = DB::table('item_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        return view('admin.monitoring.tambah')->with(['users' => $users, 'harga' => $harga, 'id_monitoring' => $id_monitoring, 'tgl_laporan' => $tgl_laporan, 'item_monitoring' => $item_monitoring]);
    }

    public function hasil_monitoring(Request $request)
    {
        $id_monitoring = $request->id_monitoring;

        $monitoring = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();

        $tgl_laporan = $monitoring->tgl_laporan;

        $hasil = DB::table('hasil_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        $harga = DB::table('harga')
            ->where('id_tipe', 1)
            ->orderBy('harga', 'desc')
            ->get();

        return view('admin.monitoring.hasil')->with(['harga' => $harga, 'hasil' => $hasil, 'id_monitoring' => $id_monitoring, 'tgl_laporan' => $tgl_laporan]);
    }

    public function store_monitoring(Request $request)
    {
        $tgl_laporan = $request->tgl_laporan;

        // dd($tgl_laporan);

        $monitoring = DB::table('monitoring')->where('tgl_laporan', date('Y-m-d', strtotime($tgl_laporan)))->first();

        if ($monitoring) {
            $pesan_tgl = 'Anda Sudah Input Data Monitoring di Tanggal ' . $tgl_laporan;
            return redirect()->route('admin.monitoring')->with(['warning' => $pesan_tgl]);
        } else {
            $harga         = $request->harga;
            $sedia         = $request->sedia;
            $users         = $request->users;
            $id_monitoring = Uuid::uuid4()->getHex();

            for ($i = 0; $i < count($harga); $i++) {
                $hasil                = new HasilMonitoring;
                $hasil->id_monitoring = $id_monitoring;
                $hasil->tgl_laporan   = $tgl_laporan;
                $hasil->harga         = $harga[$i];
                $hasil->save();
            }

            $item                = new Monitoring;
            $item->id_monitoring = $id_monitoring;
            $item->tgl_laporan   = $tgl_laporan;
            $item->save();

            for ($i = 0; $i < count($harga); $i++) {
                $hrg = DB::table('harga')
                    ->where('id_tipe', 1)
                    ->where('harga', $harga[$i])
                    ->orderBy('harga', 'desc')
                    ->first();

                // $berat[$i] =  $hrg->berat;

                $hargamonitoring                = new HargaMonitoring;
                $hargamonitoring->id_monitoring = $id_monitoring;
                $hargamonitoring->harga         = $hrg->harga;
                $hargamonitoring->berat         = $hrg->berat;
                $hargamonitoring->save();
            }

            for ($i = 0; $i < count($users); $i++) {
                for ($j = 0; $j < count($sedia[$i]); $j++) {
                    $item                = new ItemMonitoring;
                    $item->id_monitoring = $id_monitoring;
                    $item->tgl_laporan   = $tgl_laporan;
                    $item->id_user       = $users[$i];
                    $item->harga         = $harga[$j];
                    $item->sedia         = $request->sedia[$i][$j];
                    $item->save();
                }
            }
            return redirect()->route('admin.monitoring');
        }
    }

    public function store_tambah_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $tambah        = $request->tambah;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($tambah[$i]); $j++) {
                $data = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->first();

                // echo $tambah[$i][$j];
                // echo '<br>';
                // echo $data->id_item_monitoring;
                DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->update(['tambah' => $tambah[$i][$j]]);
            }
            // echo '<br><br>';
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function update_tambah_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $tambah        = $request->tambah;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($tambah[$i]); $j++) {
                $data = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->first();

                DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->update(['tambah' => $tambah[$i][$j]]);
            }
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function store_sisa_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $muda          = $request->muda;
        $tua           = $request->tua;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($muda[$i]); $j++) {
                $data = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->first();

                DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->update(['muda' => $muda[$i][$j], 'tua' => $tua[$i][$j]]);
            }
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function update_sisa_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $muda          = $request->muda;
        $tua           = $request->tua;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($muda[$i]); $j++) {
                $data = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->first();

                DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->update(['muda' => $muda[$i][$j], 'tua' => $tua[$i][$j]]);
            }
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function update_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $sedia         = $request->sedia;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($sedia[$i]); $j++) {
                // $data = DB::table('item_monitoring')
                // ->where('id_monitoring', $id_monitoring)
                // ->where('tgl_laporan', $tgl_laporan)
                // ->where('id_user', $users[$i])
                // ->where('harga', $harga[$j])
                // ->first();

                DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $users[$i])
                    ->where('harga', $harga[$j])
                    ->update(['sedia' => $sedia[$i][$j]]);
            }
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function store_hasil_monitoring(Request $request)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $harga         = $request->harga;
        $hasil         = $request->hasil;
        $users         = $request->users;
        $id_monitoring = $request->id_monitoring;

        // dd($harga);

        for ($i = 0; $i < count($harga); $i++) {
            DB::table('hasil_monitoring')
                ->where('id_monitoring', $id_monitoring)
                ->where('tgl_laporan', $tgl_laporan)
                ->where('harga', $harga[$i])
                ->update(['sedia' => $hasil[$i]]);
        }
        return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0]);
    }

    public function detail_monitoring($id_monitoring, $status, $download = false)
    {
        $user  = [];
        $hasil = [];

        $harga_kulakan = DB::table('harga')
            ->select('harga_kulakan')
            ->where('id_tipe', 3)
            ->orderBy('harga_kulakan', 'DESC')
            ->get()
            ->toArray();

        // dd($harga_kulakan[0]->harga_kulakan);

        $monitoring = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();
        $rendaman   = $monitoring->rendaman;

        $data = DB::table('item_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        $hsl = DB::table('hasil_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->get();

        foreach ($hsl as $i => $row) {
            $hasil[$i] = $row->sedia;
        }

        // dd($hasil);

        foreach ($data as $i => $value) {
            $user[$i] = $value->id_user;
        }

        $id_tipe     = $data[0]->id_tipe;
        $tgl         = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y');
        $tgl_laporan = $data[0]->tgl_laporan;

        $id_user = array_unique($user);
        $id_user = array_values($id_user);

        // dd($id_user);

        for ($i = 0; $i < count($id_user); $i++) {
            $newData = DB::table('users')
                ->where('id', $id_user[$i])
                ->where('role', 'sales')
                ->first();

            if ($newData) {
                $sales[] = $newData;
            }
        }

        // dd($sales);

        $q = DB::table('harga_monitoring')
            ->where('id_monitoring', $id_monitoring)
            ->orderBy('harga', 'desc');
        if ($download == true) {
            // $exclude = explode(',', env('EXCLUDE_HARGA', ''));
            $exclude = [
                '4000',
            ];
            $q->whereNotIn('harga', $exclude);
        }
        $harga = $q->get();
        // dd($harga);

        $cekHkm = HargaKulakanMonitoring::where('id_monitoring', $id_monitoring)->first();
        // dd($cek);
        if ($cekHkm == null) {
            $hargas = Harga::where('id_tipe', 3)
                ->orderBy('harga', 'DESC')
                ->get();

            foreach ($hargas as $key => $h) {
                $hk[] = $h->harga_kulakan;
            }

            $hkm                = new HargaKulakanMonitoring;
            $hkm->id_monitoring = $id_monitoring;
            $hkm->harga_kulakan = implode(',', $hk);
            $hkm->save();
        } else {
            $hk = explode(',', $cekHkm->harga_kulakan);
        }
        // dd($hkm);
        foreach ($harga as $i => $row) {
            $total_sedia[$i] = DB::table('item_monitoring')
                ->where('id_monitoring', $id_monitoring)
                ->where('harga', $row->harga)
                ->sum('sedia');

            if ($download == false) {
                $total_tambah[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('tambah');

                $total_tambah_sales[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('tambah_sales');

                $total_sisa_muda[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('sisa_muda');

                $total_sisa_tua[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('sisa_tua');

                $total_muda[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('muda');

                $total_tua[$i] = DB::table('item_monitoring')
                    ->where('id_monitoring', $id_monitoring)
                    ->where('harga', $row->harga)
                    ->sum('tua');

            }

            $total_laku[$i] = DB::table('item_monitoring')
                ->where('id_monitoring', $id_monitoring)
                ->where('harga', $row->harga)
                ->sum('laku');

            $hasil_kotor['sedia'][$i] = $hk[$i] * $total_sedia[$i];
            $hasil_kotor['laku'][$i]  = $hk[$i] * $total_laku[$i];
            $hasil_kotor['total'][$i] = $hasil_kotor['sedia'][$i] + $hasil_kotor['laku'][$i];

            // dd($hasil_kotor['sedia']);

            // if ($hk != NULL) {
            // 	$hasil_kotor['sedia'][$i] = $hk[$i] * $total_sedia[$i];
            // 	$hasil_kotor['laku'][$i] = $hk[$i] * $total_laku[$i];
            // }else{
            // 	$hasil_kotor['sedia'][$i] = 0;
            // 	$hasil_kotor['laku'][$i] = 0;
            // }
        }

        // $this->sync($tgl_laporan, $usersSync, $hargaSync, $id_monitoring);

        // return view('admin.monitoring.detail')->with(['data' => $data, 'hasil_kotor' => $hasil_kotor, 'hasil' => $hasil, 'sales' => $sales, 'harga' => $harga, 'tgl_laporan' => $tgl_laporan, 'id_monitoring' => $id_monitoring, 'total_sedia' => $total_sedia, 'total_tambah' => $total_tambah, 'total_muda' => $total_muda, 'total_tua' => $total_tua, 'total_sisa_muda' => $total_sisa_muda, 'total_sisa_tua' => $total_sisa_tua, 'total_laku' => $total_laku,'tgl' => $tgl,'rendaman' => $rendaman,'total_tambah_sales' => $total_tambah_sales, 'status' => $status]);

        if ($download == false) {
            return view('admin.monitoring.detail')->with([
                'data'               => $data,
                'hasil_kotor'        => $hasil_kotor,
                'hasil'              => $hasil,
                'sales'              => $sales,
                'harga'              => $harga,
                'tgl_laporan'        => $tgl_laporan,
                'id_monitoring'      => $id_monitoring,
                'total_sedia'        => $total_sedia,
                'total_tambah'       => $total_tambah,
                'total_muda'         => $total_muda,
                'total_tua'          => $total_tua,
                'total_sisa_muda'    => $total_sisa_muda,
                'total_sisa_tua'     => $total_sisa_tua,
                'total_laku'         => $total_laku,
                'tgl'                => $tgl,
                'rendaman'           => $rendaman,
                'total_tambah_sales' => $total_tambah_sales,
                'status'             => $status,
            ]);
        } else {
            $result = [
                'data'          => $data,
                'hasil_kotor'   => $hasil_kotor,
                'hasil'         => $hasil,
                'sales'         => $sales,
                'harga'         => $harga,
                'tgl_laporan'   => $tgl_laporan,
                'id_monitoring' => $id_monitoring,
                'total_sedia'   => $total_sedia,
                'total_laku'    => $total_laku,
                'tgl'           => $tgl,
                'rendaman'      => $rendaman,
                'status'        => $status,
            ];

            return $result;
        }
    }

    public function delete_monitoring($id_monitoring)
    {
        $data = DB::table('monitoring')->where('id_monitoring', $id_monitoring)->first();

        $laporan = DB::table('laporan')->whereDate('tgl_laporan', $data->tgl_laporan)->first();

        $data_laporan = DB::table('laporan')->whereDate('tgl_laporan', $data->tgl_laporan)->first();

        if ($data_laporan == null) {
            DB::table('monitoring')->where('id_monitoring', $id_monitoring)->delete();
            DB::table('item_monitoring')->where('id_monitoring', $id_monitoring)->delete();
            DB::table('hasil_monitoring')->where('id_monitoring', $id_monitoring)->delete();
        } else {
            if ($data_laporan->hutang_baru) {
                $piutang = $data_laporan->piutang - $data_laporan->hutang_baru;
                DB::table('users')->where('id', $data_laporan->id_user)->update(['piutang' => $piutang]);
            } else if ($data_laporan->pelunasan) {
                $piutang = $data_laporan->piutang + $data_laporan->pelunasan;
                DB::table('users')->where('id', $data_laporan->id_user)->update(['piutang' => $piutang]);
            }

            if ($laporan) {
                DB::table('laporan')->where('id_laporan', $laporan->id_laporan)->delete();
                DB::table('item_laporan')->where('id_laporan', $laporan->id_laporan)->delete();
            }
            DB::table('monitoring')->where('id_monitoring', $id_monitoring)->delete();
            DB::table('item_monitoring')->where('id_monitoring', $id_monitoring)->delete();
            DB::table('hasil_monitoring')->where('id_monitoring', $id_monitoring)->delete();
        }

        return redirect()->route('admin.monitoring');
    }

    public function detailSetoran(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
            'id_user' => ['required', 'integer', 'exists:users,id'],
            'id_tipe' => ['required', 'integer', 'exists:tipe,id_tipe'],
        ]);
        $from = $validated['from'];
        $to = $validated['to'];
        $id_user = $validated['id_user'];
        $id_tipe = $validated['id_tipe'];

        $get = (object) [
            'from'    => $request->from,
            'to'      => $request->to,
            'id_user' => $request->id_user,
            'id_tipe' => $request->id_tipe,
        ];

        $data = Laporan::join('users', 'laporan.id_user', '=', 'users.id')
            ->select('laporan.*', 'users.name')
            ->where('laporan.id_user', $id_user)
            ->where('laporan.id_tipe', $id_tipe)
            ->whereBetween('laporan.tgl_laporan', [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()])
            ->orderBy('laporan.tgl_laporan', 'ASC')
            ->get();

        $setoran = Laporan::join('users', 'laporan.id_user', '=', 'users.id')
            ->select('laporan.*', 'users.name')
            ->where('laporan.id_user', $id_user)
            ->where('laporan.id_tipe', $id_tipe)
            ->whereBetween('laporan.tgl_laporan', [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()])
            ->orderBy('laporan.tgl_laporan', 'ASC')
            ->sum('laporan.setoran');

        // dd($data);

        return view('admin.laporan.detail_setoran')->with(['data' => $data, 'setoran' => $setoran, 'get' => $get]);
    }

    public function detail($id_laporan)
    {
        $laporan = DB::table('laporan')
            ->where('id_laporan', $id_laporan)
            ->firstOrFail();

        $data = DB::table('item_laporan')
            ->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
            ->get();

        abort_if($data->isEmpty(), 404);

        // dd($data);

        $tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
        $acc         = $data[0]->acc ? Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s') : '-';
        $status      = $data[0]->status;
        $day_laporan = date('l', strtotime($data[0]->tgl_laporan));
        $day_acc     = date('l', strtotime($data[0]->acc));

        // dd($data[0]->tgl_laporan);

        $tgl        = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
        $monitoring = [];
        $sedia = [];
        $tambah = [];

        $datas = DB::table('item_monitoring')
            ->whereDate('tgl_laporan', $tgl)
            ->where('id_user', $laporan->id_user)
            ->orderBy('harga', 'desc')
            ->get();

        // dd($datas);

        if (count($datas) != 0) {
            foreach ($datas as $i => $row) {
                $sedia[$i]  = $row->sedia;
                $tambah[$i] = $row->tambah_sales;
            }
        } else {
            foreach ($data as $i => $item) {
                $sedia[$i] = 0;
                $tambah[$i] = $item->tambah ?? 0;
            }
        }

        return view('admin.laporan.detail')->with(['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'sedia' => $sedia, 'tambah' => $tambah]);
    }

    public function edit($id_laporan)
    {
        $this->authorizeReportManagement();

        $laporan = DB::table('laporan')
            ->where('id_laporan', $id_laporan)
            ->firstOrFail();

        $user = User::where('id', $laporan->id_user)->first();

        // dd($user);

        $data = DB::table('item_laporan')
            ->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
            ->get();

        abort_if($data->isEmpty(), 404);

        // dd($data);
        $tgl         = $data[0]->tgl_laporan;
        $tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
        $acc         = $data[0]->acc ? Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s') : '-';
        $status      = $data[0]->status;
        $day_laporan = date('l', strtotime($data[0]->tgl_laporan));
        $day_acc     = date('l', strtotime($data[0]->acc));

        // dd($data[0]->tgl_laporan);

        $tgl        = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
        $monitoring = [];
        $sedia = [];
        $tambah = [];

        $datas = DB::table('item_monitoring')
            ->whereDate('tgl_laporan', $tgl)
            ->where('id_user', $laporan->id_user)
            ->orderBy('harga', 'desc')
            ->get();

        // dd($datas);

        if (count($datas) != 0) {
            foreach ($datas as $i => $row) {
                $sedia[$i]  = $row->sedia;
                $tambah[$i] = $row->tambah_sales;
            }
        } else {
            foreach ($data as $i => $item) {
                $sedia[$i] = 0;
                $tambah[$i] = $item->tambah ?? 0;
            }
        }

        // dd($sedia);

        return view('admin.laporan.edit')->with([
            'id_laporan'  => $id_laporan,
            'data'        => $data,
            'tgl_laporan' => $tgl_laporan,
            'tgl'         => $tgl,
            'acc'         => $acc,
            'status'      => $status,
            'sedia'       => $sedia,
            'tambah'      => $tambah,
            'user'        => $user,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorizeReportManagement();

        $request->validate([
            'id_laporan' => ['required', 'string', 'exists:laporan,id_laporan'],
            'tgl_laporan' => ['required', 'date_format:Y-m-d'],
            'id_user' => ['required', 'integer', 'exists:users,id'],
            'tipe' => ['required', 'integer', 'exists:tipe,id_tipe'],
            'piutang' => ['required', 'numeric', 'min:0'],
            'hutang_baru' => ['required', 'numeric', 'min:0'],
            'pelunasan' => ['required', 'numeric', 'min:0'],
            'harga' => ['required', 'array', 'min:1'],
            'harga.*' => ['required', 'numeric', 'min:0'],
            'bawa' => ['required', 'array', 'min:1'],
            'bawa.*' => ['required', 'numeric', 'min:0'],
            'tambah' => ['required', 'array', 'min:1'],
            'tambah.*' => ['required', 'numeric', 'min:0'],
            'sisa_muda' => ['required', 'array', 'min:1'],
            'sisa_muda.*' => ['required', 'numeric', 'min:0'],
            'sisa_tua' => ['required', 'array', 'min:1'],
            'sisa_tua.*' => ['required', 'numeric', 'min:0'],
            'sedia' => ['required', 'array', 'min:1'],
            'sedia.*' => ['required', 'numeric', 'min:0'],
        ]);

        $itemCount = count($request->harga);
        foreach (['bawa', 'tambah', 'sisa_muda', 'sisa_tua', 'sedia'] as $field) {
            if (count($request->input($field, [])) !== $itemCount) {
                throw ValidationException::withMessages([
                    $field => 'Jumlah baris item laporan tidak konsisten.',
                ]);
            }
        }

        // dd($request);

        $sisa        = [];
        $laku        = [];
        $jumlah      = [];
        $jumlah_laku = 0;
        $bawa        = $request->bawa;
        $sisa_muda   = $request->sisa_muda;
        $sisa_tua    = $request->sisa_tua;
        $harga       = $request->harga;
        $hutang_baru = $request->hutang_baru;
        $pelunasan   = $request->pelunasan;
        $id_laporan  = $request->id_laporan;
        $sedia       = $request->sedia;
        $tambah      = $request->tambah;
        $bw          = 0;

        for ($i = 0; $i < count($bawa); $i++) {
            $bw = $bw + $bawa[$i];
        }

        if ($bw == 0) {
            return back()->withInput()->with(['warning' => 'Bawa & Sisa Wajib Diisi']);
        }

        for ($i = 0; $i < count($harga); $i++) {
            $sisa[$i] = $sisa_muda[$i] + $sisa_tua[$i];
            if ($sisa[$i] > $bawa[$i]) {
                return back()->withInput()->with(['warning' => 'Sisa Tidak Boleh Lebih Dari Bawa']);
            }
        }

        if ($pelunasan > $request->piutang) {
            return back()->withInput()->with(['warning' => 'Pelunasan Tidak Boleh Lebih Dari Piutang']);
        }

        for ($i = 0; $i < count($harga); $i++) {
            $laku[$i]   = ($bawa[$i] + $tambah[$i]) - $sisa[$i];
            $jumlah[$i] = $laku[$i] * $harga[$i];
        }

        for ($i = 0; $i < count($jumlah); $i++) {
            $jumlah_laku = $jumlah_laku + $jumlah[$i];
        }

        $tipe = Tipe::where('id_tipe', $request->tipe)
            ->first();

        if ($hutang_baru != 0 && $pelunasan == 0) {
            $piutang = $request->piutang + $hutang_baru;
            // DB::table('users')->where('id', $user->id)->update([ 'piutang' => $piutang ]);
            if ($tipe->margin == 1) {
                $marginsales = ($jumlah_laku * 10) / 100;
                $setoran     = ($jumlah_laku - $marginsales) - $hutang_baru;
            } else {
                $marginsales = 0;
                $setoran     = $jumlah_laku - $hutang_baru;
            }
        } elseif ($hutang_baru == 0 && $pelunasan != 0) {
            $piutang = $request->piutang - $pelunasan;
            // DB::table('users')->where('id', $user->id)->update(['piutang' => $piutang ]);
            if ($tipe->margin == 1) {
                $marginsales = ($jumlah_laku * 10) / 100;
                $setoran     = ($jumlah_laku - $marginsales) + $pelunasan;
            } else {
                $marginsales = 0;
                $setoran     = $jumlah_laku + $pelunasan;
            }
        } elseif ($hutang_baru != 0 && $pelunasan != 0) {
            $piutang = ($request->piutang - $pelunasan) + $hutang_baru;
            if ($tipe->margin == 1) {
                $marginsales = ($jumlah_laku * 10) / 100;
                $setoran     = ($jumlah_laku - $marginsales) - ($hutang_baru - $pelunasan);
            } else {
                $marginsales = 0;
                $setoran     = $jumlah_laku - ($hutang_baru - $pelunasan);
            }
        } else {
            $piutang = $request->piutang;
            if ($tipe->margin == 1) {
                $marginsales = ($jumlah_laku * 10) / 100;
                $setoran     = $jumlah_laku - $marginsales;
            } else {
                $marginsales = 0;
                $setoran     = $jumlah_laku;
            }
        }

        $laporan = [
            'hutang_baru' => $hutang_baru,
            'pelunasan'   => $pelunasan,
            'jumlah_laku' => $jumlah_laku,
            'marginsales' => $marginsales,
            'piutang'     => $piutang,
            'setoran'     => $setoran,
        ];

        DB::transaction(function () use ($request, $id_laporan, $laporan, $harga, $bawa, $tambah, $laku, $sisa_muda, $sisa_tua, $piutang) {
            Laporan::where('id_laporan', $id_laporan)->update($laporan);

            for ($i = 0; $i < count($harga); $i++) {
                ItemLaporan::where('id_laporan', $id_laporan)->where('harga', $harga[$i])->update([
                    'harga' => $harga[$i],
                    'bawa' => $bawa[$i],
                    'tambah' => $tambah[$i],
                    'laku' => $laku[$i],
                    'sisa_muda' => $sisa_muda[$i],
                    'sisa_tua' => $sisa_tua[$i],
                ]);
            }

            $itemMonitoring = ItemMonitoring::whereBetween('tgl_laporan', [
                Carbon::parse($request->tgl_laporan)->startOfDay(),
                Carbon::parse($request->tgl_laporan)->endOfDay(),
            ])->where('id_user', $request->id_user)
                ->orderBy('harga', 'desc')
                ->get();

            foreach ($itemMonitoring as $index => $monitoring) {
                ItemMonitoring::where('id_item_monitoring', $monitoring->id_item_monitoring)->update([
                    'sisa_muda' => $sisa_muda[$index],
                    'sisa_tua' => $sisa_tua[$index],
                    'tambah_sales' => $tambah[$index],
                ]);
            }

            User::where('id', $request->id_user)->update(['piutang' => $piutang]);
        });

        return redirect()->route('admin.detail', $id_laporan);
    }

    public function status($id_laporan)
    {
        $this->authorizeReportManagement();

        $updated = DB::table('laporan')
            ->where('id_laporan', $id_laporan)
            ->where('status', '0')
            ->update(['status' => '1', 'acc' => Carbon::now()]);

        if (! $updated && ! DB::table('laporan')->where('id_laporan', $id_laporan)->exists()) {
            abort(404);
        }

        return redirect()->route('admin.home')->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function hapus($id_laporan)
    {
        $this->authorizeReportManagement();

        DB::transaction(function () use ($id_laporan) {
            $laporan = DB::table('laporan')
                ->where('id_laporan', $id_laporan)
                ->lockForUpdate()
                ->first();

            abort_if(! $laporan, 404);

            $piutang = $laporan->piutang - $laporan->hutang_baru + $laporan->pelunasan;
            User::where('id', $laporan->id_user)->update(['piutang' => $piutang]);

            ItemLaporan::where('id_laporan', $id_laporan)->delete();
            Laporan::where('id_laporan', $id_laporan)->delete();

            ItemMonitoring::whereBetween('tgl_laporan', [
                Carbon::parse($laporan->tgl_laporan)->startOfDay(),
                Carbon::parse($laporan->tgl_laporan)->endOfDay(),
            ])->where('id_user', $laporan->id_user)->update([
                'sisa_muda' => 0,
                'sisa_tua' => 0,
            ]);
        });

        return redirect()->route('admin.home')->with('success', 'Laporan berhasil dihapus.');
    }

    public function filter(Request $request)
    {
        $id_user = $request->$id_user;
        dd($id_user);
    }

    // public function edit($id_item_laporan)
    // {
    // 	$data = DB::table('item_laporan')
    // 	->orderBy('harga', 'desc')
    // 	->where('id_item_laporan', $id_item_laporan)
    // 	->get();

    // 	// return view('admin.laporan.edit')->with(['data' => $data]);
    // }

    public function cetakExcel(Request $request)
    {
        $request->merge([
            'id_user' => $request->id_user === 'NULL' ? null : $request->id_user,
        ]);
        $validated = $request->validate([
            'id_user' => ['nullable', 'integer', 'exists:users,id'],
            'id_tipe' => ['required', 'integer', 'exists:tipe,id_tipe'],
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);

        // $q = DB::table('laporan')
        // ->join('users', 'laporan.id_user', '=', 'users.id')
        // ->select('laporan.*', 'users.name', 'users.piutang');

        // if($request->from){
        //     $q->whereDate('laporan.tgl_laporan', '>=', $request->from)
        //     ->whereDate('laporan.tgl_laporan', '<=', $request->to);
        // }else{
        //     $now = Carbon::now();
        //     $month = $now->month;
        //     $q->whereMonth('laporan.tgl_laporan', '=', $month);
        // }

        // if($request->id_user != 'NULL'){
        //     $q->where('laporan.id_user', $request->id_user);
        // }

        // if($request->id_tipe != 'NULL'){
        //     $q->where('laporan.id_tipe', $request->id_tipe);
        // }

        // $laporan = $q->orderBy('laporan.tgl_laporan', 'asc')->get();

        // $item_laporan = DB::table('item_laporan')
        // ->orderBy('harga', 'desc')
        // ->get();

        // $harga = DB::table('harga')
        // ->where('id_tipe', '=', $request->id_tipe)
        // ->orderBy('harga', 'desc')
        // ->get();

        // $tipe = DB::table('tipe')
        // ->orderBy('tipe', 'asc')
        // ->get();

        // return view('admin.laporan.cetak')->with(['laporan' => $laporan, 'item_laporan' => $item_laporan, 'harga' => $harga, 'tipe' => $tipe]);

        $nama_file = 'laporan_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new LaporanExport(
            $validated['id_user'] ?? null,
            (string) $validated['id_tipe'],
            $validated['from'],
            $validated['to']
        ), $nama_file);
    }

    public function pdf(Request $request)
    {
        $validated = $request->validate([
            'id_laporan' => ['required', 'string', 'exists:laporan,id_laporan'],
        ]);
        $id_laporan = $validated['id_laporan'];

        $laporan = DB::table('laporan')
            ->where('id_laporan', $id_laporan)
            ->firstOrFail();

        $sales = DB::table('users')
            ->join('laporan', 'users.id', '=', 'laporan.id_user')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('users.*', 'laporan.*')
            ->get();

        $data = DB::table('item_laporan')
            ->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
            ->get();

        abort_if($data->isEmpty() || $sales->isEmpty(), 404);

        $tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
        $acc         = $data[0]->acc ? Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s') : '-';
        $status      = $data[0]->status;

        $tgl        = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
        $monitoring = [];

        $datas = DB::table('item_monitoring')
            ->whereDate('tgl_laporan', $tgl)
            ->where('id_user', $laporan->id_user)
            ->orderBy('harga', 'desc')
            ->get();

        // dd($datas);

        if (count($datas) != 0) {
            foreach ($datas as $i => $row) {
                $monitoring[$i] = $row->sedia + $row->tambah;
            }
        } else {
            $nominal = DB::table('harga')
                ->orderBy('harga', 'desc')
                ->where('id_tipe', $laporan->id_tipe)
                ->get();
            foreach ($nominal as $i => $hrg) {
                $monitoring[$i] = 0;
            }
        }

        // dd($monitoring);

        $pdf = PDF::loadview('admin.laporan.pdf', ['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'nama' => $sales[0]->name, 'monitoring' => $monitoring]);
        return $pdf->stream();
    }

    public function pdfKasir(Request $request)
    {
        $validated = $request->validate([
            'id_laporan' => ['required', 'string', 'exists:laporan,id_laporan'],
        ]);
        $id_laporan = $validated['id_laporan'];

        $laporan = DB::table('laporan')
            ->where('id_laporan', $id_laporan)
            ->firstOrFail();

        $sales = DB::table('users')
            ->join('laporan', 'users.id', '=', 'laporan.id_user')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('users.*', 'laporan.*')
            ->get();

        $data = DB::table('item_laporan')
            ->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
            ->where('laporan.id_laporan', $id_laporan)
            ->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
            ->get();

        abort_if($data->isEmpty() || $sales->isEmpty(), 404);

        $tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
        $acc         = $data[0]->acc ? Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s') : '-';
        $status      = $data[0]->status;

        $tgl        = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
        $monitoring = [];

        $datas = DB::table('item_monitoring')
            ->whereDate('tgl_laporan', $tgl)
            ->where('id_user', $laporan->id_user)
            ->orderBy('harga', 'desc')
            ->get();

        // dd($datas);

        if (count($datas) != 0) {
            foreach ($datas as $i => $row) {
                $monitoring[$i] = $row->sedia + $row->tambah;
            }
        } else {
            $nominal = DB::table('harga')
                ->orderBy('harga', 'desc')
                ->where('id_tipe', $laporan->id_tipe)
                ->get();
            foreach ($nominal as $i => $hrg) {
                $monitoring[$i] = 0;
            }
        }

        // dd($monitoring);

        return view('admin.laporan.pdf_kasir')->with(['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'monitoring' => $monitoring]);

        // $pdf = PDF::loadview('admin.laporan.pdf',['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'nama' => $sales[0]->name, 'monitoring' => $monitoring]);
        // return $pdf->stream();
    }

    public function cetakpdf(Request $request)
    {
        $validated = $request->validate([
            'id_user' => ['nullable', 'integer', 'exists:users,id'],
            'id_tipe' => ['nullable', 'integer', 'exists:tipe,id_tipe'],
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);
        $id_user = $validated['id_user'] ?? null;
        $id_tipe = $validated['id_tipe'] ?? null;
        $from = $validated['from'];
        $to = $validated['to'];

        $q = Laporan::leftJoin('users', 'laporan.id_user', '=', 'users.id')
            ->leftJoin('tipe', 'laporan.id_tipe', '=', 'tipe.id_tipe')
            ->select('laporan.*', 'users.name', 'users.piutang', 'tipe.tipe');

        $q->whereBetween('laporan.tgl_laporan', [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay(),
        ]);

        if ($id_user) {
            $q->where('laporan.id_user', $id_user);
        }

        if ($id_tipe) {
            $q->where('laporan.id_tipe', $id_tipe);
        }

        $data = $q->orderBy('laporan.tgl_laporan', 'asc')->get();
        $itemsByReport = DB::table('item_laporan')
            ->whereIn('id_laporan', $data->pluck('id_laporan'))
            ->get()
            ->groupBy('id_laporan');
        $monitoringByUserDate = DB::table('item_monitoring')
            ->whereIn('id_user', $data->pluck('id_user')->unique())
            ->whereBetween('tgl_laporan', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ])
            ->get()
            ->groupBy(fn ($item) => $item->id_user.'|'.Carbon::parse($item->tgl_laporan)->format('Y-m-d'));

        $item_laporan = [];
        $item_monitoring = [];
        foreach ($data as $index => $laporan) {
            $item_laporan[$index] = $itemsByReport->get($laporan->id_laporan, collect());
            $monitoringKey = $laporan->id_user.'|'.Carbon::parse($laporan->tgl_laporan)->format('Y-m-d');
            $item_monitoring[$index] = $monitoringByUserDate->get($monitoringKey, collect());
        }

        $pdf = PDF::loadview('admin.laporan.cetakpdf', ['data' => $data, 'item_laporan' => $item_laporan, 'item_monitoring' => $item_monitoring]);
        return $pdf->stream();
    }

    public function cetakMonitoring(Request $request)
    {
        $from = $request->from;
        $to   = $request->to;

        if (! $from || ! $to) {
            return redirect()->back();
        }

        $query = DB::table('monitoring')->orderBy('tgl_laporan', 'asc');

        // Filter by date range if provided
        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from');
            $to   = $request->input('to');
            $query->whereBetween('tgl_laporan', [$from, $to]);
        } else {
            $query->whereMonth('tgl_laporan', date('m'))
                ->whereYear('tgl_laporan', date('Y'));
        }

        $datas = $query->get();
        foreach ($datas as $key => $data) {
            $results[] = $this->detail_monitoring($data->id_monitoring, 1, true);
        }

        // return view('admin.laporan.cetakmonitoring')->with(['results' => $results]);
        $pdf = PDF::loadview('admin.laporan.cetakmonitoring', ['results' => $results]);
        return $pdf->stream();
    }

    public function sinkronisasi(Request $request, $cronjob = false)
    {
        $tgl_laporan   = $request->tgl_laporan;
        $users         = $request->users;
        $harga         = $request->harga;
        $id_monitoring = $request->id_monitoring;
        // dd($request->all());
        foreach ($users as $key => $sales) {
            if ($sales['tipe'] == '2') {
                $laporan = Laporan::whereDate('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $sales['id'])
                    ->first();

                if ($laporan) {
                    $id_laporan = $laporan->id_laporan;

                    foreach ($harga as $key => $hrg) {
                        $data = ItemMonitoring::select('sedia')
                            ->where('id_monitoring', $id_monitoring)
                            ->where('id_user', $sales['id'])
                            ->where('harga', $hrg)
                            ->first();

                        if ($data) {
                            ItemMonitoring::where('id_monitoring', $id_monitoring)
                                ->where('id_user', $sales['id'])
                                ->where('harga', $hrg)
                                ->update(['laku' => $data->sedia]);
                        }
                    }
                }
            } else {
                $laporan = Laporan::whereDate('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $sales['id'])
                    ->first();

                if ($laporan) {
                    $id_laporan = $laporan->id_laporan;

                    foreach ($harga as $key => $hrg) {
                        $item_laporan = DB::table('item_laporan')
                            ->where('id_laporan', $id_laporan)
                            ->where('harga', $hrg)
                            ->first();

                        if ($item_laporan) {
                            ItemMonitoring::where('id_monitoring', $id_monitoring)
                                ->where('id_user', $sales['id'])
                                ->where('harga', $hrg)
                                ->update(['laku' => $item_laporan->laku]);
                        }
                    }
                }
            }
        }

		if ($cronjob == false) {
			return redirect()->route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 1]);
		}
    }

    public function sync($tgl_laporan, $users, $harga, $id_monitoring)
    {
        // $tgl_laporan = $request->tgl_laporan;
        // $users = $request->users;
        // $harga = $request->harga;
        // $id_monitoring = $request->id_monitoring;
        // dd($request->all());
        foreach ($users as $key => $sales) {
            if ($sales['tipe'] == '2') {
                $laporan = DB::table('laporan')
                    ->whereDate('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $sales['id'])
                    ->first();

                if ($laporan) {
                    $id_laporan = $laporan->id_laporan;

                    foreach ($harga as $key => $hrg) {
                        $data = DB::table('item_monitoring')
                            ->select('sedia')
                            ->where('id_monitoring', $id_monitoring)
                            ->where('id_user', $sales['id'])
                            ->where('harga', $hrg)
                            ->first();

                        if ($data) {
                            DB::table('item_monitoring')
                                ->where('id_monitoring', $id_monitoring)
                                ->where('id_user', $sales['id'])
                                ->where('harga', $hrg)
                                ->update(['laku' => $data->sedia]);
                        }
                    }
                }
            } else {
                $laporan = DB::table('laporan')
                    ->whereDate('tgl_laporan', $tgl_laporan)
                    ->where('id_user', $sales['id'])
                    ->first();

                if ($laporan) {
                    $id_laporan = $laporan->id_laporan;

                    foreach ($harga as $key => $hrg) {
                        $item_laporan = DB::table('item_laporan')
                            ->where('id_laporan', $id_laporan)
                            ->where('harga', $hrg)
                            ->first();

                        if ($item_laporan) {
                            DB::table('item_monitoring')
                                ->where('id_monitoring', $id_monitoring)
                                ->where('id_user', $sales['id'])
                                ->where('harga', $hrg)
                                ->update(['laku' => $item_laporan->laku]);
                        }
                    }
                }
            }
        }
    }

    public function hardcode(Request $request)
    {
        $data = DB::table('monitoring')
            ->orderBy('tgl_laporan', 'desc')
            ->get();

        // dd($data);

        for ($i = 0; $i < count($data); $i++) {
            $hargamonitoring                = new HargaMonitoring;
            $hargamonitoring->id_monitoring = $data[$i]->id_monitoring;
            $hargamonitoring->harga         = 7500;
            $hargamonitoring->berat         = 0.78;
            $hargamonitoring->save();

            $hargamonitoring                = new HargaMonitoring;
            $hargamonitoring->id_monitoring = $data[$i]->id_monitoring;
            $hargamonitoring->harga         = 5000;
            $hargamonitoring->berat         = 0.52;
            $hargamonitoring->save();

            $hargamonitoring                = new HargaMonitoring;
            $hargamonitoring->id_monitoring = $data[$i]->id_monitoring;
            $hargamonitoring->harga         = 4000;
            $hargamonitoring->berat         = 0.42;
            $hargamonitoring->save();

            $hargamonitoring                = new HargaMonitoring;
            $hargamonitoring->id_monitoring = $data[$i]->id_monitoring;
            $hargamonitoring->harga         = 3000;
            $hargamonitoring->berat         = 0.32;
            $hargamonitoring->save();
        }
    }
}
