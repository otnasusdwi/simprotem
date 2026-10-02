<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Kulit;
use App\Models\Laporan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class AdminKulitController extends Controller
{
	public function index(Request $request)
	{
		$tgl = $request->tgl;

		$get = (object)[
			'tgl' => $request->tgl,
		];

		if($tgl){
			$data = DB::table('kulit')
			->join('pelanggan', 'kulit.id_pelanggan', '=', 'pelanggan.id')
			->select('kulit.*', 'pelanggan.name')
			->where('kulit.tgl', '=', $tgl)
			->orderBy('pelanggan.id', 'asc')
			->get();

			$jml_kulit = DB::table('kulit')
			->where('kulit.tgl', '=', $tgl)
			->sum('kulit');

			$jml_harga = DB::table('kulit')
			->where('kulit.tgl', '=', $tgl)
			->sum('harga');

			$jml_bayar = DB::table('kulit')
			->where('kulit.tgl', '=', $tgl)
			->sum('bayar');
		}else{
			$data = [];
			$jml_kulit = 0;
			$jml_harga = 0;
			$jml_bayar = 0;
		}

		$get = (object)[
			'tgl' => $tgl
		];

		// dd($jml_kulit);

		return view('admin.kulit.list')->with(['data' => $data, 'jml_kulit' => $jml_kulit, 'jml_harga' => $jml_harga, 'get' => $get, 'jml_bayar' => $jml_bayar]);
	}


	public function create()
	{
		$data = DB::table('pelanggan')
		->orderBy('id', 'asc')
		->get();

		return view('admin.kulit.create')->with(['data' => $data]);
	}

	public function store(Request $request)
	{
		$tgl = $request->tgl;
		$id_pelanggan = $request->id_pelanggan;
		$jml = $request->kulit;
		$bayar = $request->bayar;

		// dd($kulit);

		$kulit = DB::table('kulit')
		->whereDate('tgl', $tgl)
		->first();

		$pesan = 'Anda Sudah Input Data Kulit di Tanggal ' . $tgl;

		if ($kulit) {
			return redirect()->route('admin.input_kulit')->with(['warning' => $pesan]);
		}else{
			for ($i = 0; $i < count($id_pelanggan); $i++) {
				$data = new Kulit;
				$data->tgl = $tgl;
				$data->id_pelanggan = $id_pelanggan[$i];
				$data->kulit = $jml[$i];
				$data->harga = $jml[$i]*15000;
				$data->bayar = $bayar[$i];
				$data->save();
			}
		}

		$get = (object)[
			'tgl' => $tgl
		];

		return redirect('admin/kulit?tgl='.$get->tgl)->with(['data' => $data, 'get' => $get, 'success' => 'Data Stok Kulit Berhasil Ditambah']);
	}

	public function edit_data_kulit(Request $request)
	{
		$tgl = $request->tgl;

		$get = (object)[
			'tgl' => $request->tgl,
		];

		$data = DB::table('kulit')
		->join('pelanggan', 'kulit.id_pelanggan', '=', 'pelanggan.id')
		->select('kulit.*', 'pelanggan.name')
		->whereDate('kulit.tgl', '=', $tgl)
		->orderBy('pelanggan.id', 'asc')
		->get();

		// dd($tgl);


		return view('admin.kulit.edit_data_kulit')->with(['data' => $data, 'get' => $get]);
	}

	public function update_data_kulit(Request $request)
	{
		$tgl = $request->tgl;

		$get = (object)[
			'tgl' => $request->tgl,
		];

		for ($i = 0; $i < count($request->id); $i++) {
			DB::table('kulit')
			->where('id', $request->id[$i] )
			->update([
				'kulit' => $request->kulit[$i],
				'harga' => $request->kulit[$i]*15000,
				'bayar' => $request->bayar[$i]
			]);
		}
		// dd($tgl);

		return redirect('admin/kulit?tgl='.$tgl)->with(['get' => $get]);
		// return view('admin.kulit.edit_data_kulit')->with(['data' => $data, 'get' => $get]);
	}

	public function edit(Request $request)
	{
		$id_pelanggan = $request->id_pelanggan;
		$tgl = $request->tgl;

		$month = Carbon::parse($tgl)->translatedFormat('m');$bulan_kemarin = '2020-'.($month-1).'-01';
		$last = Carbon::parse($bulan_kemarin)->endOfMonth()->toDateString();

		$data_last = DB::table('kulit')
		->where('id_pelanggan', $id_pelanggan)
		->where('tgl', $last )
		->first();

		if (empty($data_last)) {
			$tagihan = 0;
		}else{
			$tagihan = $data_last->tagihan;
		}

		$pelanggan = DB::table('pelanggan')
		->where('id', $id_pelanggan)
		->first();

		$bulan = Carbon::parse($tgl)->translatedFormat('F Y');

		$data = DB::table('kulit')
		->where('id_pelanggan', $id_pelanggan)
		->whereMonth('tgl', $month)
		->orderBy('tgl', 'asc')
		->get();

		return view('admin.kulit.edit')->with(['data' => $data, 'tagihan' => $tagihan, 'id_pelanggan' => $id_pelanggan, 'tgl' => $tgl, 'pelanggan' => $pelanggan, 'bulan' => $bulan]);
	}

	public function update(Request $request)
	{
		$tgl = $request->tgl;
		$bayar = $request->bayar;
		$harga = $request->harga;
		$id_pelanggan = $request->id_pelanggan;
		$tagihan[0] = 0;

		$month = Carbon::parse($tgl[0])->translatedFormat('m');
		$bulan_kemarin = '2020-'.($month-1).'-01';
		$last = Carbon::parse($bulan_kemarin)->endOfMonth()->toDateString();

		for ($i = 0; $i < count($bayar); $i++) {
			if ($i == 0) {
				$data = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->where('tgl', $last )
				->first();

				if ($data) {
					$tagihan[$i] = $bayar[$i] - ($data->tagihan + $harga[$i]);
					if ($tagihan[$i] < 0) {
						$tagihan[$i] = $tagihan[$i] * (-1);
					}

					// dd($tagihan);

					DB::table('kulit')
					->where('id_pelanggan', $id_pelanggan)
					->where('tgl', $tgl[$i] )
					->update([
						'bayar' => $bayar[$i],
						'tagihan' => $tagihan[$i]
					]);
				}else{
					DB::table('kulit')
					->where('id_pelanggan', $id_pelanggan)
					->where('tgl', $tgl[$i] )
					->update([
						'bayar' => $bayar[$i],
						'tagihan' => $bayar[$i] - $harga[$i]
					]);
				}
			}else{
				$data = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $tgl[$i])
				->first();

				$tagihan[$i] = $bayar[$i] - ($tagihan[$i-1] + $harga[$i]);
				if ($tagihan[$i] < 0) {
					$tagihan[$i] = $tagihan[$i] * (-1);
				}

				// dd($tagihan);

				DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->where('tgl', $tgl[$i])
				->update([
					'bayar' => $bayar[$i],
					'tagihan' => $tagihan[$i]
				]);
			}
		}

		$get = (object)[
			'tgl' => $tgl[0],
			'id_pelanggan' => $id_pelanggan
		];

		return redirect('admin/detail_kulit?id_pelanggan='.$get->id_pelanggan.'&tgl='.$get->tgl)->with(['get' => $get, 'success' => 'Data Stok Kulit Berhasil Diupdate']);
	}


	public function kulitBulanan(Request $request)
	{
        $years = Laporan::generateYearRange();

		$pelanggan = Pelanggan::get()->toArray();

		$month = $request->month;
		$year = $request->year;

		$get = (object)[
			'month' => $request->month,
			'year' => $request->year,
		];

		if($month && $year){

			// dd($year);
			$kulit = [];
			$tghn = [];
			$now = Carbon::now();
			// $month = $now->month;
			// $year = $now->year;
			// $month = '12';
			// $year = '2021';

			for ($i=0; $i < count($pelanggan); $i++) {

				// $kulit[] = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
				// ->whereMonth('tgl', $month)
				// ->whereYear('tgl', $year)
				// ->select('id_pelanggan')
				// ->selectRaw("SUM(kulit) as total_kulit")
				// ->selectRaw("SUM(harga) as total_harga")
				// ->selectRaw("SUM(bayar) as total_bayar")
				// ->selectRaw("SUM(tagihan) as total_tagihan")
				// ->groupBy('id_pelanggan')
				// ->get()
				// ->toArray();

				$kulit[] = Kulit::select('kulit.*', 'pelanggan.*')
                ->leftJoin('pelanggan', 'pelanggan.id', '=', 'kulit.id_pelanggan')
				->where('kulit.id_pelanggan', $pelanggan[$i]['id'])
				->whereMonth('kulit.tgl', $month)
				->whereYear('kulit.tgl', $year)
				->select('kulit.id_pelanggan', 'pelanggan.name as nama_pelanggan')
				->selectRaw("SUM(kulit.kulit) as total_kulit")
				->selectRaw("SUM(kulit.harga) as total_harga")
				->selectRaw("SUM(kulit.bayar) as total_bayar")
				->selectRaw("SUM(kulit.tagihan) as total_tagihan")
				->groupBy('kulit.id_pelanggan')
				->get()
				->toArray();
				// $kulit[$i] = $data;

				$harga = 0;
				$bayar = 0;
				$tagihan = 0;

				if ($month == 1) {
					$bln = 12;
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}
					$tagihan = $harga - $bayar;
				}else{
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $month-($j+1))
						->whereYear('tgl', $year)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $month-($j+1))
						->whereYear('tgl', $year)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}

					$bln = 12;
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}
					$tagihan = $harga - $bayar;
				}
				// echo $i. '<br>';
				$tghn[$i] = $tagihan;
			}

		}else{
			$kulit = [];
			$tghn = [];
			$now = Carbon::now();
			$month = $now->month;
			$year = $now->year;
			// $month = '12';
			// $year = '2021';
			for ($i=0; $i < count($pelanggan); $i++) {

				// $kulit[] = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
				// ->whereMonth('tgl', $month)
				// ->whereYear('tgl', $year)
				// ->select('id_pelanggan')
				// ->selectRaw("SUM(kulit) as total_kulit")
				// ->selectRaw("SUM(harga) as total_harga")
				// ->selectRaw("SUM(bayar) as total_bayar")
				// ->selectRaw("SUM(tagihan) as total_tagihan")
				// ->groupBy('id_pelanggan')
				// ->get()
				// ->toArray();

				$kulit[] = Kulit::select('kulit.*', 'pelanggan.*')
                ->leftJoin('pelanggan', 'pelanggan.id', '=', 'kulit.id_pelanggan')
				->where('kulit.id_pelanggan', $pelanggan[$i]['id'])
				->whereMonth('kulit.tgl', $month)
				->whereYear('kulit.tgl', $year)
				->select('kulit.id_pelanggan', 'pelanggan.name as nama_pelanggan')
				->selectRaw("SUM(kulit.kulit) as total_kulit")
				->selectRaw("SUM(kulit.harga) as total_harga")
				->selectRaw("SUM(kulit.bayar) as total_bayar")
				->selectRaw("SUM(kulit.tagihan) as total_tagihan")
				->groupBy('kulit.id_pelanggan')
				->get()
				->toArray();

				// $kulit[$i] = $data;

				$harga = 0;
				$bayar = 0;
				$tagihan = 0;

				if ($month == 1) {
					$bln = 12;
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}
					$tagihan = $harga - $bayar;
				}else{
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $month-($j+1))
						->whereYear('tgl', $year)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $month-($j+1))
						->whereYear('tgl', $year)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}

					$bln = 12;
					for ($j = 0; $j < 12; $j++) {
						$hrg = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('harga');
						$harga = $harga + $hrg;

						$byr = Kulit::where('id_pelanggan', $pelanggan[$i]['id'])
						->whereMonth('tgl', $bln-($j))
						->whereYear('tgl', $year-1)
						->sum('bayar');
						$bayar = $bayar + $byr;
					}
					$tagihan = $harga - $bayar;
				}
				// echo $i. '<br>';
				$tghn[$i] = $tagihan;
			}
		}

		$get = (object)[
			'month' => $month,
			'year' => $year
		];

		// dd($kulit);

		return view('admin.kulit.bulanan')->with([
			'kulit' => $kulit,
			'tagihan' => $tghn,
			'pelanggan' => $pelanggan,
			'years' => $years,
			'get' => $get
		]);
	}

	public function detail(Request $request)
	{
		$id_pelanggan = $request->id_pelanggan;
		$tgl = $request->tgl;

		$month = Carbon::parse($tgl)->translatedFormat('m');
		$year = Carbon::parse($tgl)->translatedFormat('Y');

		// $bulan_kemarin = '2020-'.($month-1).'-01';
		// $last = Carbon::parse($bulan_kemarin)->endOfMonth()->toDateString();

		$harga = 0;
		$bayar = 0;

		if ($month == 1) {
			$bln = 12;
			for ($i = 0; $i < 12; $i++) {
				$hrg = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $bln-($i))
				->whereYear('tgl', $year-1)
				->sum('harga');
				$harga = $harga + $hrg;

				$byr = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $bln-($i))
				->whereYear('tgl', $year-1)
				->sum('bayar');
				$bayar = $bayar + $byr;
			}
			$tagihan = $harga - $bayar;
		}else{
			for ($i = 0; $i < 12; $i++) {
				$hrg = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $month-($i+1))
				->whereYear('tgl', $year)
				->sum('harga');
				$harga = $harga + $hrg;

				$byr = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $month-($i+1))
				->whereYear('tgl', $year)
				->sum('bayar');
				$bayar = $bayar + $byr;
			}

			$bln = 12;
			for ($i = 0; $i < 12; $i++) {
				$hrg = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $bln-($i))
				->whereYear('tgl', $year-1)
				->sum('harga');
				$harga = $harga + $hrg;

				$byr = DB::table('kulit')
				->where('id_pelanggan', $id_pelanggan)
				->whereMonth('tgl', $bln-($i))
				->whereYear('tgl', $year-1)
				->sum('bayar');
				$bayar = $bayar + $byr;
			}
			$tagihan = $harga - $bayar;
		}

		$pelanggan = DB::table('pelanggan')
		->where('id', $id_pelanggan)
		->first();

		$bulan = Carbon::parse($tgl)->translatedFormat('F Y');

		$data = DB::table('kulit')
		->where('id_pelanggan', $id_pelanggan)
		->whereMonth('tgl', $month)
		->whereYear('tgl', $year)
		->orderBy('tgl', 'asc')
		->get();

		// dd($data);

		return view('admin.kulit.detail')->with(['data' => $data, 'tagihan' => $tagihan, 'id_pelanggan' => $id_pelanggan, 'tgl' => $tgl, 'pelanggan' => $pelanggan, 'bulan' => $bulan]);
	}
}
