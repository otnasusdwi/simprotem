<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Kedelai;
use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminKedelaiController extends Controller
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
			$data = DB::table('kedelai')
			->where('bulan', $bulan)
			->where('tahun', $tahun)
			// ->orderBy('tgl', 'asc')
			->get();

			if (count($data) == 0) {
				$harga = 0;
				$sisa_lalu = 0;
			}else{
				$harga = $data[0]->harga;
				$sisa_lalu = $data[0]->sisa_lalu;
			}
		}else{
			$data = [];
			$harga = 0;
			$sisa_lalu = 0;
		}

		// dd($data);

		return view('admin.kedelai.list')->with(['data' => $data, 'harga' => $harga, 'sisa_lalu' => $sisa_lalu, 'get' => $get, 'years' => $years]);
	}

	public function create()
	{
        $years = Laporan::generateYearRange();
		return view('admin.kedelai.create')->with(['years' => $years]);
	}

	public function store(Request $request)
	{
		$harga = $request->harga;
		$bulan = $request->bulan;
		$tahun = $request->tahun;
		$sisa_lalu = $request->sisa;

		$kedelai = DB::table('kedelai')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->first();

		$pesan = 'Anda Sudah Input Stok di Bulan ' . $bulan . ' - ' . $tahun;

		if ($kedelai) {
			return redirect()->route('admin.input_kedelai')->with(['warning' => $pesan]);
		}else{
			for ($i = 0; $i < count($request->tgl); $i++) {
				if ($i == 0) {

					if ($request->tempe[$i] != 0 && $request->datang[$i] == 0) {
						$sisa[$i] = $sisa_lalu - $request->tempe[$i];
					}elseif ($request->datang[$i] != 0 && $request->tempe[$i] == 0){
						$sisa[$i] = $sisa_lalu + $request->datang[$i];
					}elseif ($request->tempe[$i] != 0 && $request->datang[$i] != 0){
						$sisa[$i] = ($sisa_lalu + $request->datang[$i]) - $request->tempe[$i];
					}else{
						$sisa[$i] = $sisa_lalu;
					}

					$kedelai = new Kedelai;
					$kedelai->harga = $harga;
					$kedelai->bulan = $bulan;
					$kedelai->tahun = $tahun;
					$kedelai->tgl = $request->tgl[$i];
					$kedelai->tempe = $request->tempe[$i];
					$kedelai->datang = $request->datang[$i];
					$kedelai->sisa = $sisa[$i];
					$kedelai->sisa_lalu = $sisa_lalu;
					$kedelai->save();

				}else{

					if ($request->tempe[$i] != 0 && $request->datang[$i] == 0) {
						$sisa[$i] = $sisa[$i-1] - $request->tempe[$i];
					}elseif ($request->datang[$i] != 0 && $request->tempe[$i] == 0){
						$sisa[$i] = $sisa[$i-1] + $request->datang[$i];
					}elseif ($request->tempe[$i] != 0 && $request->datang[$i] != 0){
						$sisa[$i] = ($sisa[$i-1] + $request->datang[$i]) - $request->tempe[$i];
					}else{
						$sisa[$i] = $sisa[$i-1];
					}

					$kedelai = new Kedelai;
					$kedelai->harga = $harga;
					$kedelai->bulan = $bulan;
					$kedelai->tahun = $tahun;
					$kedelai->tgl = $request->tgl[$i];
					$kedelai->tempe = $request->tempe[$i];
					$kedelai->datang = $request->datang[$i];
					$kedelai->sisa = $sisa[$i];
					$kedelai->sisa_lalu = $sisa_lalu;
					$kedelai->save();
				}
			}
		}


		$get = (object)[
			'bulan' => $bulan,
			'tahun' => $tahun
		];

		$data = DB::table('kedelai')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->orderBy('tgl', 'asc')
		->get();

		return redirect('admin/kedelai?bulan='.$get->bulan.'&tahun='.$get->tahun)->with(['data' => $data, 'get' => $get, 'success' => 'Data Stok Kedelai Berhasil Ditambah']);
	}

	public function edit(Request $request)
	{
		$bulan = $request->bulan;
		$tahun = $request->tahun;

		$data = DB::table('kedelai')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		// ->orderBy('created_at', 'desc')
		->get();

		// dd($bulan);

		return view('admin.kedelai.edit')->with(['data' => $data, 'bulan' => $bulan, 'tahun' => $tahun]);
	}

	public function update(Request $request)
	{

		// dd($request->tempe);
		$harga = $request->harga;
		$bulan = $request->bulan;
		$tahun = $request->tahun;
		$sisa_lalu = $request->sisa;

		for ($i = 0; $i < count($request->id); $i++) {
			if ($i == 0) {

				if ($request->tempe[$i] != 0 && $request->datang[$i] == 0) {
					$sisa[$i] = $sisa_lalu - $request->tempe[$i];
				}elseif ($request->datang[$i] != 0 && $request->tempe[$i] == 0){
					$sisa[$i] = $sisa_lalu + $request->datang[$i];
				}elseif ($request->tempe[$i] != 0 && $request->datang[$i] != 0){
					$sisa[$i] = ($sisa_lalu + $request->datang[$i]) - $request->tempe[$i];
				}else{
					$sisa[$i] = $sisa_lalu;
				}

				DB::table('kedelai')
				->where('id', $request->id[$i])
				->update([
					'tempe' => $request->tempe[$i],
					'datang' => $request->datang[$i],
					'harga' => $harga,
					'sisa' => $sisa[$i],
					'sisa_lalu' => $sisa_lalu
				]);
			}else{

				if ($request->tempe[$i] != 0 && $request->datang[$i] == 0) {
					$sisa[$i] = $sisa[$i-1] - $request->tempe[$i];
				}elseif ($request->datang[$i] != 0 && $request->tempe[$i] == 0){
					$sisa[$i] = $sisa[$i-1] + $request->datang[$i];
				}elseif ($request->tempe[$i] != 0 && $request->datang[$i] != 0){
					$sisa[$i] = ($sisa[$i-1] + $request->datang[$i]) - $request->tempe[$i];
				}else{
					$sisa[$i] = $sisa[$i-1];
				}

				DB::table('kedelai')
				->where('id', $request->id[$i])
				->update([
					'tempe' => $request->tempe[$i],
					'datang' => $request->datang[$i],
					'harga' => $harga,
					'sisa' => $sisa[$i],
					'sisa_lalu' => $sisa_lalu
				]);
			}
		}

		$get = (object)[
			'bulan' => $bulan,
			'tahun' => $tahun
		];

		$data = DB::table('kedelai')
		->where('bulan', $bulan)
		->where('tahun', $tahun)
		->orderBy('tgl', 'asc')
		->get();

		return redirect('admin/kedelai?bulan='.$get->bulan.'&tahun='.$get->tahun)->with(['data' => $data, 'get' => $get, 'success' => 'Data Stok Kedelai Berhasil Diupdate']);
	}
}
