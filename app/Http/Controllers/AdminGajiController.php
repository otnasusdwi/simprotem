<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Gaji;
use App\Models\Laporan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminGajiController extends Controller
{
	public function index(Request $request)
	{

        $years = Laporan::generateYearRange();
		$bulan = $request->bulan;
		$tahun = $request->tahun;

		$get = (object)[
			'bulan' => $request->bulan,
			'tahun' => $request->tahun
		];

		if($bulan && $tahun){
			$data[0] = DB::table('gaji')
			->join('karyawan', 'gaji.id_karyawan', '=', 'karyawan.id')
			->select('gaji.*', 'karyawan.name')
			->where('bulan', $bulan)
			->where('tahun', $tahun)
			->where('tgl_gaji', '1')
			->orderBy('created_at', 'desc')
			->get();

			$data[1] = DB::table('gaji')
			->join('karyawan', 'gaji.id_karyawan', '=', 'karyawan.id')
			->select('gaji.*', 'karyawan.name')
			->where('bulan', $bulan)
			->where('tahun', $tahun)
			->where('tgl_gaji', '15')
			->orderBy('created_at', 'desc')
			->get();
		}else{
			$data[0] = [];
			$data[1] = [];
		}

		return view('admin.gaji.list')->with(['data' => $data, 'get' => $get, 'years' => $years]);
	}

	public function create()
	{
        $years = Laporan::generateYearRange();
		$karyawan = DB::table('karyawan')
		->orderBy('name', 'asc')
		->get();

		return view('admin.gaji.create')->with(['karyawan' => $karyawan, 'years' => $years]);
	}

	public function store(Request $request)
	{
		// dd($request->masuk[0]);
		// $tgl_gaji = $request->tgl_gaji;
		$bulan = $request->bulan;
		$tahun = $request->tahun;

		$gaji = DB::table('gaji')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->first();

		$pesan = 'Anda Sudah Input Gaji di Bulan ' . $bulan . ' - ' . $tahun;

		if ($gaji) {
			return redirect()->route('admin.input_gaji')->with(['warning' => $pesan]);
		}else{
			$karyawan = $request->karyawan[0];
			$masuk = $request->masuk[0];
			$gaji_karyawan = $request->gaji_karyawan[0];
			$hutang = $request->hutang[0];
			$jaga_malam = $request->jaga_malam[0];

			for ($i = 0; $i < count($karyawan); $i++) {
				$gaji = new Gaji;
				$gaji->id_karyawan = $karyawan[$i];
				$gaji->tgl_gaji = 1;
				$gaji->bulan = $bulan;
				$gaji->tahun = $tahun;
				$gaji->masuk = $masuk[$i];
				$gaji->gaji_karyawan = $gaji_karyawan[$i];
				$gaji->hutang = $hutang[$i];
				$gaji->jaga_malam = $jaga_malam[$i];
				$gaji->save();
			}

			$karyawan = $request->karyawan[1];
			$masuk = $request->masuk[1];
			$gaji_karyawan = $request->gaji_karyawan[1];
			$hutang = $request->hutang[1];
			$jaga_malam = $request->jaga_malam[1];

			for ($i = 0; $i < count($karyawan); $i++) {
				$gaji = new Gaji;
				$gaji->id_karyawan = $karyawan[$i];
				$gaji->tgl_gaji = 15;
				$gaji->bulan = $bulan;
				$gaji->tahun = $tahun;
				$gaji->masuk = $masuk[$i];
				$gaji->gaji_karyawan = $gaji_karyawan[$i];
				$gaji->hutang = $hutang[$i];
				$gaji->jaga_malam = $jaga_malam[$i];
				$gaji->save();
			}

			return redirect()->route('admin.gaji')->with(['success' => 'Data Gaji Berhasil Ditambahkan']);
		}
	}

	public function edit(Request $request)
	{
		$bulan = $request->bulan;
		$tahun = $request->tahun;

		$data[0] = DB::table('gaji')
		->join('karyawan', 'gaji.id_karyawan', '=', 'karyawan.id')
		->select('gaji.*', 'karyawan.name')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->where('tgl_gaji', 1)
		->get();

		$data[1] = DB::table('gaji')
		->join('karyawan', 'gaji.id_karyawan', '=', 'karyawan.id')
		->select('gaji.*', 'karyawan.name')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->where('tgl_gaji', 15)
		->get();

		return view('admin.gaji.edit')->with(['data' => $data, 'bulan' => $bulan, 'tahun' => $tahun]);
	}

	public function update(Request $request)
	{
		$id = $request->id[0];
		$masuk = $request->masuk[0];
		$gaji_karyawan = $request->gaji_karyawan[0];
		$hutang = $request->hutang[0];
		$jaga_malam = $request->jaga_malam[0];

		for ($i = 0; $i < count($id); $i++) {
			DB::table('gaji')
			->where('id', $id[$i])
			->update([
				'masuk' => $masuk[$i],
				'gaji_karyawan' => $gaji_karyawan[$i],
				'hutang' => $hutang[$i],
				'jaga_malam' => $jaga_malam[$i]
			]);
		}

		$id = $request->id[1];
		$masuk = $request->masuk[1];
		$gaji_karyawan = $request->gaji_karyawan[1];
		$hutang = $request->hutang[1];
		$jaga_malam = $request->jaga_malam[1];

		for ($i = 0; $i < count($id); $i++) {
			DB::table('gaji')
			->where('id', $id[$i])
			->update([
				'masuk' => $masuk[$i],
				'gaji_karyawan' => $gaji_karyawan[$i],
				'hutang' => $hutang[$i],
				'jaga_malam' => $jaga_malam[$i]
			]);
		}

		$bulan = $request->bulan;
		$tahun = $request->tahun;

		$get = (object)[
			'bulan' => $bulan,
			'tahun' => $tahun
		];

		// dd($get);

		$data[0] = DB::table('gaji')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->where('tgl_gaji', '1')
		->orderBy('created_at', 'desc')
		->get();

		// dd($data[0]);

		$data[1] = DB::table('gaji')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->where('tgl_gaji', '15')
		->orderBy('created_at', 'desc')
		->get();

		return redirect('admin/gaji?bulan='.$get->bulan.'&tahun='.$get->tahun)->with(['data' => $data, 'get' => $get, 'success' => 'Data Gaji Berhasil Diupdate']);
	}
}
