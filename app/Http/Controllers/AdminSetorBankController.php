<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Carbon\Carbon;
use App\Models\Laporan;
use App\Models\SetorBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSetorBankController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $get = (object)[
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        $setor_bank = [];

        if ($bulan && $tahun) {
            $setor_bank = DB::table('setor_bank')
                ->select('setor_bank.*')
                ->whereRaw("DATE_FORMAT(tgl_setor, '%m-%Y') = ?", ["$bulan-$tahun"])
                ->orderBy('setor_bank.tgl_setor', 'asc')
                ->get();
        }

        return view('admin.setor_bank.list', [
            'setor_bank' => $setor_bank,
            'get' => $get
        ]);
    }

    public function create(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $get = (object)[
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('admin.setor_bank.create')->with(['get' => $get]);
    }

    public function store(Request $request)
    {
        $dataToInsert = [];
        $formattedTgl = Carbon::createFromFormat('d-m-Y', '01-' . $request->tgl)->format('Y-m-d');
        foreach (range(0, $request->rows - 1) as $index) {
            $dataToInsert[] = [
                'tgl' => $formattedTgl,
                'tgl_setor' => $request->tgl_setor[$index] ?? null,
                'uang_masuk' => $request->uang_masuk[$index] ?? 0,
                'pengeluaran' => $request->pengeluaran[$index] ?? 0,
                'setor_bank' => (isset($request->uang_masuk[$index]) && isset($request->pengeluaran[$index])) ? $request->uang_masuk[$index] - $request->pengeluaran[$index] : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SetorBank::insert($dataToInsert);
        $bulan = Carbon::parse($formattedTgl)->format('m');
        $tahun = Carbon::parse($formattedTgl)->format('Y');
        $get = (object)[
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return redirect('admin/setor_bank?bulan=' . $get->bulan . '&tahun=' . $get->tahun)->with(['get' => $get, 'success' => 'Data Berhasil Ditambah']);
    }

    public function edit(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $get = (object)[
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        $data = SetorBank::whereRaw("DATE_FORMAT(tgl_setor, '%m-%Y') = ?", ["$bulan-$tahun"])->get();

        return view('admin.setor_bank.edit')->with(['data' => $data, 'get' => $get]);
    }

    public function update(Request $request)
    {
        // Delete existing records for the specified month and year
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $formattedTgl = Carbon::createFromFormat('Y-m-d', "$tahun-$bulan-01")->format('Y-m-d');
        SetorBank::whereRaw("DATE_FORMAT(tgl, '%m-%Y') = ?", ["$bulan-$tahun"])->delete();

        // Insert updated records
        $dataToInsert = [];
        foreach (range(0, $request->rows - 1) as $index) {
            $dataToInsert[] = [
                'tgl' => $formattedTgl,
                'tgl_setor' => $request->tgl_setor[$index] ?? null,
                'uang_masuk' => $request->uang_masuk[$index] ?? 0,
                'pengeluaran' => $request->pengeluaran[$index] ?? 0,
                'setor_bank' => (isset($request->uang_masuk[$index]) && isset($request->pengeluaran[$index])) ? $request->uang_masuk[$index] - $request->pengeluaran[$index] : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SetorBank::insert($dataToInsert);

        $get = (object)[
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return redirect('admin/setor_bank?bulan=' . $get->bulan . '&tahun=' . $get->tahun)->with(['get' => $get, 'success' => 'Data Setor Bank Berhasil Diupdate']);
    }

    public function detail(Request $request, $print = false)
    {
        $tgl = $request->tgl;

        $month = Carbon::parse($tgl)->translatedFormat('m');
        $year = Carbon::parse($tgl)->translatedFormat('Y');

        $debit_sales = DB::table('laporan')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->sum('setoran');

        $debit_pengeluaran = DB::table('debit_pengeluaran')
        ->whereMonth('tgl', $month)
        ->whereYear('tgl', $year)
        ->whereNotIn('id_pengeluaran', [11])
        ->sum('debit');

        $debit = $debit_sales + $debit_pengeluaran;

        $kredit = DB::table('debit_pengeluaran')
        ->whereMonth('tgl', $month)
        ->whereYear('tgl', $year)
        ->whereNotIn('id_pengeluaran', [11])
        ->sum('kredit');

        $kedelai = DB::table('kedelai')
        ->where('bulan', date("m", strtotime($tgl)))
        ->where('tahun', date("Y", strtotime($tgl)))
        ->get();

        $pengeluaran = DB::table('pengeluaran')
        // ->whereNotIn('id', [11])
        ->orderBy('name', 'asc')
        ->get();
        $rincian = [];

        // dd($kredit);

        foreach ($pengeluaran as $i => $row) {
            $rincian[$i]['kredit'] = DB::table('debit_pengeluaran')
            ->whereMonth('tgl', $month)
            ->whereYear('tgl', $year)
            ->where('id_pengeluaran', $row->id)
            // ->whereNotIn('id_pengeluaran', [11])
            ->sum('kredit');

            $rincian[$i]['qty'] = DB::table('debit_pengeluaran')
            ->whereMonth('tgl', $month)
            ->whereYear('tgl', $year)
            ->where('id_pengeluaran', $row->id)
            // ->whereNotIn('id_pengeluaran', [11])
            ->count('kredit');

            $rincian[$i]['id'] = $row->id;
            $rincian[$i]['name'] = $row->name;
        }

        // dd($rincian);

        $pemakaian_kedelai = 0;

        foreach ($kedelai as $row) {
            $pemakaian_kedelai = $pemakaian_kedelai + ($row->harga*($row->tempe * 50));
        }

        $get = (object)[
            'tgl' => $tgl
        ];

        // dd($rincian);
        if ($print == true) {
            $result = [
                'debit' => $debit,
                'pemakaian_kedelai' => $pemakaian_kedelai,
                'kredit' => $kredit,
                'tgl' => $tgl,
                'get' => $get,
                'rincian' => $rincian
            ];
            return $result;
        } else {
            return view('admin.setor_bank.detail')->with([
                'debit' => $debit,
                'pemakaian_kedelai' => $pemakaian_kedelai,
                'kredit' => $kredit,
                'tgl' => $tgl,
                'get' => $get,
                'rincian' => $rincian
            ]);
        }
    }

    public function cetakKredit(Request $request)
    {
        $data = $this->detail($request, true);
        // return view('admin.laporan.cetakkredit')->with(['data' => $data]);
        $pdf = PDF::loadview('admin.laporan.cetakkredit', ['data' => $data]);
        return $pdf->stream();
    }

    public function delete($id)
    {
        $data = DB::table('debit_pengeluaran')
        ->where('id', $id)
        ->first();

        $tgl = $data->tgl;

        $get = (object)[
            'tgl' => $tgl
        ];

        DB::table('debit_pengeluaran')->where('id', $id)->delete();

        return redirect('admin/debit?tgl='.$get->tgl)->with(['get' => $get, 'success' => 'Data Debit Kredit Harian Berhasil Dihapus']);
    }

    public function detail_pengeluaran(Request $request)
    {
        $tgl = $request->tgl;
        $id = $request->id;

        $month = Carbon::parse($tgl)->translatedFormat('m');
        $year = Carbon::parse($tgl)->translatedFormat('Y');

        $data = DB::table('debit_pengeluaran')
        ->join('pengeluaran', 'debit_pengeluaran.id_pengeluaran', '=', 'pengeluaran.id')
        ->select('debit_pengeluaran.*', 'pengeluaran.name')
        ->where('debit_pengeluaran.id_pengeluaran', $id)
        ->whereMonth('debit_pengeluaran.tgl', $month)
        ->whereYear('debit_pengeluaran.tgl', $year)
        ->get();

        // dd($data);

        $get = (object)[
            'tgl' => $tgl
        ];

        return view('admin.setor_bank.pengeluaran')->with(['data' => $data, 'get' => $get]);
    }
}
