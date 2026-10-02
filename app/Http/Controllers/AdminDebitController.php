<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DebitPengeluaran;
use DB;
use PDF;
use Carbon\Carbon;

class AdminDebitController extends Controller
{
	public function index(Request $request)
	{
		$tgl = $request->tgl;
		
		$get = (object)[
			'tgl' => $request->tgl,
		];
		
		if($tgl){
			$debit_sales = DB::table('laporan')
			->join('users', 'laporan.id_user', '=', 'users.id')
			->select('laporan.*', 'users.name', 'users.piutang')
			->whereDate('laporan.acc', '=', $tgl)
			->orderBy('laporan.tgl_laporan', 'desc')
			->get();

			$jml_debit_sales = DB::table('laporan')
			->whereDate('laporan.acc', '=', $tgl)
			->sum('setoran');

			$jml_kredit_sales = 0;

			$debit_pengeluaran = DB::table('debit_pengeluaran')
			->join('pengeluaran', 'debit_pengeluaran.id_pengeluaran', '=', 'pengeluaran.id')
			->select('debit_pengeluaran.*', 'pengeluaran.name')
			->whereDate('debit_pengeluaran.tgl', '=', $tgl)
			->orderBy('debit_pengeluaran.created_at', 'asc')
			->get();

			$jml_debit_pengeluaran = DB::table('debit_pengeluaran')
			->whereDate('debit_pengeluaran.tgl', '=', $tgl)
			->sum('debit');

			$jml_kredit_pengeluaran = DB::table('debit_pengeluaran')
			->whereDate('debit_pengeluaran.tgl', '=', $tgl)
			->sum('kredit');

			$sales = DB::table('users')
			->where('role', 'sales')
			->orderBy('name', 'asc')
			->get();

		}else{
			$debit_sales = [];
			$debit_pengeluaran = [];
			$jml_debit_sales = 0;
			$jml_kredit_sales = 0;
			$jml_debit_pengeluaran = 0;
			$jml_kredit_pengeluaran = 0;

			$sales = DB::table('users')
			->where('role', 'sales')
			->orderBy('name', 'asc')
			->get();
		}

		$get = (object)[
			'tgl' => $tgl
		];

		return view('admin.debit.list')->with(['debit_sales' => $debit_sales, 'debit_pengeluaran' => $debit_pengeluaran, 'jml_debit_sales' => $jml_debit_sales, 'jml_kredit_sales' => $jml_kredit_sales, 'jml_debit_pengeluaran' => $jml_debit_pengeluaran, 'jml_kredit_pengeluaran' => $jml_kredit_pengeluaran, 'get' => $get, 'sales' => $sales]);
	}

	public function create(Request $request)
	{
		$tgl = $request->tgl;

		$sales = DB::table('users')
		->where('role', 'sales')
		->orderBy('name', 'asc')
		->get();

		$pengeluaran = DB::table('pengeluaran')
		->orderBy('name', 'asc')
		->get();

		$get = (object)[
			'tgl' => $tgl
		];

		return view('admin.debit.create')->with(['sales' => $sales, 'pengeluaran' => $pengeluaran, 'get' => $get]);
	}

	public function store(Request $request)
	{
		$data = new DebitPengeluaran;
		$data->tgl = $request->tgl;
		$data->ket = $request->ket;
		$data->id_pengeluaran = $request->id_pengeluaran;
		$data->tgl_setor = $request->tgl;
		$data->debit = $request->debit;
		$data->kredit = $request->kredit;
		$data->save();

		$get = (object)[
			'tgl' => $request->tgl
		];

		return redirect('admin/debit?tgl='.$get->tgl)->with(['get' => $get, 'success' => 'Data Stok Kulit Berhasil Ditambah']);
	}

	public function edit(Request $request)
	{
		$sales = DB::table('users')
		->where('role', 'sales')
		->orderBy('name', 'asc')
		->get();

		$pengeluaran = DB::table('pengeluaran')
		->orderBy('name', 'asc')
		->get();

		$data = DB::table('debit_pengeluaran')
		->where('id', $request->id)
		->first();

		return view('admin.debit.edit')->with(['sales' => $sales, 'pengeluaran' => $pengeluaran, 'data' => $data]);
	}

	public function update(Request $request)
	{
		DB::table('debit_pengeluaran')
		->where('id', $request->id)
		->update([
			'ket' => $request->ket,
			'id_pengeluaran' => $request->id_pengeluaran,
			'debit' => $request->debit,
			'kredit' => $request->kredit,
		]);

		$get = (object)[
			'tgl' => $request->tgl
		];

		return redirect('admin/debit?tgl='.$get->tgl)->with(['get' => $get, 'success' => 'Data Debit Kredit Harian Berhasil Diupdate']);
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
			return view('admin.debit.detail')->with([
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

		return view('admin.debit.pengeluaran')->with(['data' => $data, 'get' => $get]);
	}
}
