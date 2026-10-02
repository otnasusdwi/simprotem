<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Harga;
use App\Models\Tipe;
use App\Models\Laporan;
use App\Models\ItemLaporan;
use App\Models\Monitoring;
use App\Models\ItemMonitoring;
use App\Models\HasilMonitoring;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;
use Response;
use Excel;
use App\Exports\LaporanExport;
use App\Exports\SinglePdf;
use Dompdf\Dompdf;
use PDF;

class SalesHomeController extends Controller
{
	public function index()
	{
		return view('sales.home');
	}

	public function lapor(Request $request)
	{
		$tgl_laporan = $request->tgl_laporan;

		$monitoring = DB::table('monitoring')
		->where('tgl_laporan', date('Y-m-d', strtotime($tgl_laporan)))
		->first();

		// dd($monitoring);

		if ($monitoring) {
			$tgl = DB::table('laporan')
			->where('id_user', Auth::user()->id)
			->whereDate('tgl_laporan', date('Y-m-d', strtotime($tgl_laporan)))
			->first();

			$pesan_tgl = 'Anda Sudah Laporan di Tanggal ' . $tgl_laporan;

			if ($tgl) {
				return redirect()->route('sales.home')->with(['warning' => $pesan_tgl]);
			}else{
				$monitoring = [];

				$datas = DB::table('item_monitoring')
				->whereDate('tgl_laporan', $tgl_laporan)
				->where('id_user', Auth::user()->id)
				->orderBy('harga', 'desc')
				->get();

				// dd($datas);

				if (count($datas) != 0) {
					foreach ($datas as $i => $data) {
						$sedia[$i] = $data->sedia;
						$tambah[$i] = $data->tambah;
					}
				}else{
					$harga = DB::table('harga')
					->orderBy('harga', 'desc')
					->where('id_tipe', Auth::user()->tipe)
					->get();
					foreach ($harga as $i => $hrg) {
						$monitoring[$i] = 0;
					}
				}

				$harga = DB::table('harga')
				->orderBy('harga', 'desc')
				->where('id_tipe', Auth::user()->tipe)
				->get();

				$tgl = Carbon::parse($tgl_laporan)->translatedFormat('l, d F Y');

				return view('sales.lapor')->with(['harga' => $harga, 'sedia' => $sedia, 'tambah' => $tambah, 'tgl_laporan' => $tgl_laporan, 'tgl' => $tgl]);
			}
		}else{
			$pesan_tgl = 'Admin Belum Input Data Sedia di Tanggal ' . $tgl_laporan;
			return redirect()->route('sales.home')->with(['warning' => $pesan_tgl]);
		}
	}
	
	public function validasi(Request $request)
	{	
		$sisa =[];
		$laku =[];
		$jumlah = [];
		$jumlah_laku = 0;
		$bawa = $request->bawa;
		$sisa_muda = $request->sisa_muda;
		$sisa_tua = $request->sisa_tua;
		$harga = $request->harga;
		$hutang_baru = $request->hutang_baru;
		$pelunasan = $request->pelunasan;
		$tgl_laporan = $request->tgl_laporan;
		$sedia = $request->sedia;
		$tambah = $request->tambah;
		$bw = 0;

		// dd($sedia);
		
		for ($i=0; $i < count($bawa); $i++) { 
			$bw = $bw + $bawa[$i];
		}
		
		if ($bw == 0) {
			return redirect()->route('sales.home')->with(['warning' => 'Bawa & Sisa Wajib Diisi']);
		}
		
		for ($i=0; $i < count($harga); $i++) { 
			$sisa[$i] = $sisa_muda[$i] + $sisa_tua[$i];
			if ($sisa[$i] > $bawa[$i]) {
				return redirect()->route('sales.home')->with(['warning' => 'Sisa TIdak Boleh Lebih Dari Bawa']);
			}
		}
		
		if ($pelunasan > Auth::user()->piutang) {
			return redirect()->route('sales.home')->with(['warning' => 'Pelunasan Tidak Boleh Lebih Dari Piutang']);
		}
		
		$tgl = DB::table('laporan')
		->where('id_user', Auth::user()->id)
		->whereDate('tgl_laporan', $tgl_laporan)
		->first();
		
		$pesan_tgl = 'Anda Sudah Laporan di Tanggal ' . $tgl_laporan;
		
		if ($tgl) {
			return redirect()->route('sales.home')->with(['warning' => $pesan_tgl]);
		}else{
			for ($i = 0; $i < count($harga); $i++) {
				$laku[$i] = ($bawa[$i]+$tambah[$i]) - $sisa[$i];
				$jumlah[$i] = $laku[$i] * $harga[$i];
			}
			
			for ($i=0; $i < count($jumlah); $i++) { 
				$jumlah_laku = $jumlah_laku + $jumlah[$i];
			}
			
			$tipe = DB::table('tipe')
			->where('id_tipe', Auth::user()->tipe)
			->first();
			
			if ($hutang_baru != 0 && $pelunasan == 0) {
				$piutang = Auth::user()->piutang + $hutang_baru;
				// DB::table('users')->where('id', Auth::user()->id)->update([ 'piutang' => $piutang ]);
				
				if ($tipe->margin == 1) {
					$marginsales = ($jumlah_laku*10)/100;
					$setoran = ($jumlah_laku - $marginsales) - $hutang_baru;
				}else{
					$marginsales = 0;
					$setoran = $jumlah_laku - $hutang_baru;
				}
			}elseif ($hutang_baru == 0 && $pelunasan != 0){
				$piutang = Auth::user()->piutang - $pelunasan;
				// DB::table('users')->where('id', Auth::user()->id)->update(['piutang' => $piutang ]);
				
				if ($tipe->margin == 1) {
					$marginsales = ($jumlah_laku*10)/100;
					$setoran = ($jumlah_laku - $marginsales) + $pelunasan;
				}else{
					$marginsales = 0;
					$setoran = $jumlah_laku + $pelunasan;
				}
			}elseif($hutang_baru != 0 && $pelunasan != 0){
				
				$piutang = (Auth::user()->piutang - $pelunasan) + $hutang_baru;
				if ($tipe->margin == 1) {
					$marginsales = ($jumlah_laku*10)/100;
					$setoran = ($jumlah_laku - $marginsales) - ($hutang_baru - $pelunasan);
				}else{
					$marginsales = 0;
					$setoran = $jumlah_laku - ($hutang_baru - $pelunasan);
				}
			}else{
				$piutang = Auth::user()->piutang;
				if ($tipe->margin == 1) {
					$marginsales = ($jumlah_laku*10)/100;
					$setoran = $jumlah_laku - $marginsales;
				}else{
					$marginsales = 0;
					$setoran = $jumlah_laku;
				}
			}
			
			$user = DB::table('users')
			->where('id', Auth::user()->tipe)
			->first();
			
			$jam = Carbon::now()->format('H:i:s');
			$tgl = $tgl_laporan.' '.$jam;
			
			return view('sales.validasi',[
				'sedia' => $sedia,
				'tambah' => $tambah,
				'harga' => $harga,
				'bawa' => $bawa ,
				'laku' => $laku ,
				'sisa_muda' => $sisa_muda,
				'sisa_tua' => $sisa_tua,
				'jumlah' => $jumlah,
				'jumlah_laku' => $jumlah_laku,
				'setoran' => $setoran,
				'pelunasan' => $pelunasan,
				'piutang' => $piutang,
				'hutang_baru' => $hutang_baru,
				'tgl_laporan' => $tgl,
				'marginsales' => $marginsales
			]);
		}	
	}

	public function input(Request $request){

		$tgl = DB::table('laporan')
		->where('id_user', Auth::user()->id)
		->where('tgl_laporan', $request->tgl_laporan)
		->first();

		$pesan_tgl = 'Anda Sudah Laporan di Tanggal ' . $request->tgl_laporan;
		
		if ($tgl) {
			return redirect()->route('sales.home')->with(['warning' => $pesan_tgl]);
		}else{

			$id_laporan = Uuid::uuid4()->getHex();
			$laporan = new Laporan;
			$laporan->id_laporan = $id_laporan;
			$laporan->id_user = Auth::user()->id;
			$laporan->id_tipe = Auth::user()->tipe;
			$laporan->tgl_laporan = $request->tgl_laporan;
			$laporan->hutang_baru = $request->hutang_baru;
			$laporan->pelunasan = $request->pelunasan;
			$laporan->jumlah_laku = $request->jumlah_laku;
			$laporan->marginsales = $request->marginsales;
			$laporan->setoran = $request->setoran;
			$laporan->piutang = $request->piutang;
			$laporan->save();
			DB::table('users')->where('id', Auth::user()->id)->update(['piutang' => $request->piutang ]);
			
			for ($i = 0; $i < count($request->harga); $i++) {
				$item = new ItemLaporan;
				$item->id_laporan = $id_laporan;
				$item->harga = $request->harga[$i];
				$item->bawa = $request->bawa[$i];
				$item->tambah = $request->tambah[$i];
				$item->laku = $request->laku[$i];
				$item->sisa_muda = $request->sisa_muda[$i];
				$item->sisa_tua = $request->sisa_tua[$i];
				$item->save();
			}

			$item_monitoring = DB::table('item_monitoring')
			->whereDate('tgl_laporan', date('Y-m-d', strtotime($request->tgl_laporan)))	
			->where('id_user', Auth::user()->id)
			->orderBy('harga', 'desc')
			->get();

			for ($i = 0; $i < count($item_monitoring); $i++) {
				$data = DB::table('item_monitoring')
				->where('id_item_monitoring', $item_monitoring[$i]->id_item_monitoring)
				->update([
					'sisa_muda' => $request->sisa_muda[$i],
					'sisa_tua' => $request->sisa_tua[$i],
					'tambah_sales' => $request->tambah[$i]
				]);
			}
			return redirect()->route('sales.detail', $id_laporan);
		}
	}
	
	public function list(Request $request)
	{	
		$filter = $request->filter;
		$from = $request->from;
		$to = $request->to;
		
		$get = (object)[
			'filter' => $request->filter,
			'from' => $request->from,
			'to' => $request->to,
		];
		
		if($from){
			$data = DB::table('laporan')
			->join('users', 'laporan.id_user', '=', 'users.id')
			->select('laporan.*', 'users.name', 'users.piutang')
			->where('id', Auth::user()->id)
			->whereDate('laporan.tgl_laporan', '>=', $from)
			->whereDate('laporan.tgl_laporan', '<=', $to)
			->orderBy('created_at', 'desc')
			->get();
		}else{
			$now = Carbon::now();
			$month = $now->month;
			$data = DB::table('laporan')
			->join('users', 'laporan.id_user', '=', 'users.id')
			->select('laporan.*', 'users.name', 'users.piutang')
			->where('id', Auth::user()->id)
			->whereMonth('laporan.tgl_laporan', '=', $month)
			->orderBy('created_at', 'desc')
			->get();
		}
		
		return view('sales.list')->with(['data' => $data, 'get' => $get]);
	}
	
	public function detail($id_laporan)
	{
		$data = DB::table('item_laporan')
		->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
		->where('laporan.id_laporan', $id_laporan)
		->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
		->get();

		// dd($data);
		
		$tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
		$acc = Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s');
		$status = $data[0]->status;
		$day_laporan = date('l', strtotime($data[0]->tgl_laporan));
		$day_acc = date('l', strtotime($data[0]->acc));

		// dd($data[0]->tgl_laporan);

		$tgl = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
		$monitoring = [];

		$datas = DB::table('item_monitoring')
		->whereDate('tgl_laporan', $tgl)
		->where('id_user', Auth::user()->id)
		->orderBy('harga', 'desc')
		->get();

		// dd($datas);

		if (count($datas) != 0) {
			foreach ($datas as $i => $row) {
				$sedia[$i] = $row->sedia;
				$tambah[$i] = $row->tambah_sales;
			}
		}else{
			$nominal = DB::table('harga')
			->orderBy('harga', 'desc')
			->where('id_tipe', Auth::user()->tipe)
			->get();
			foreach ($nominal as $i => $hrg) {
				$monitoring[$i] = 0;
			}
		}

		// dd($tambah);
		
		return view('sales.detail')->with(['id_laporan' => $id_laporan,'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'sedia' => $sedia, 'tambah' => $tambah]);
	}
	
	public function pdf(Request $request)
	{
		$id_laporan = $request->id_laporan;
		
		$data = DB::table('item_laporan')
		->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
		->where('laporan.id_laporan', $id_laporan)
		->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
		->get();
		
		$tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
		$acc = Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s');
		$status = $data[0]->status;

		$tgl = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
		$monitoring = [];

		$datas = DB::table('item_monitoring')
		->whereDate('tgl_laporan', $tgl)
		->where('id_user', Auth::user()->id)
		->orderBy('harga', 'desc')
		->get();

		// dd($datas);

		if (count($datas) != 0) {
			foreach ($datas as $i => $row) {
				$monitoring[$i] = $row->sedia + $row->tambah;
			}
		}else{
			$nominal = DB::table('harga')
			->orderBy('harga', 'desc')
			->where('id_tipe', Auth::user()->tipe)
			->get();
			foreach ($nominal as $i => $hrg) {
				$monitoring[$i] = 0;
			}
		}

		// dd($monitoring);
		// return view('sales.pdf')->with(['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'monitoring' => $monitoring]);
		$pdf = PDF::loadview('sales.pdf',['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'monitoring' => $monitoring]);
		return $pdf->stream();
		
		// $nama_file = 'laporan_'.date('Y-m-d_H-i-s').'.pdf';
		// return Excel::download(new SinglePdf($id_laporan, $tgl_laporan, $nama), $nama_file,\Maatwebsite\Excel\Excel::DOMPDF);
	}

	public function pdfKasir(Request $request)
	{
		$id_laporan = $request->id_laporan;
		
		$data = DB::table('item_laporan')
		->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
		->where('laporan.id_laporan', $id_laporan)
		->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan', 'laporan.acc')
		->get();
		
		$tgl_laporan = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('l, d F Y - H:i:s');
		$acc = Carbon::parse($data[0]->acc)->translatedFormat('l, d F Y - H:i:s');
		$status = $data[0]->status;

		$tgl = Carbon::parse($data[0]->tgl_laporan)->translatedFormat('Y-m-d');
		$monitoring = [];

		$datas = DB::table('item_monitoring')
		->whereDate('tgl_laporan', $tgl)
		->where('id_user', Auth::user()->id)
		->orderBy('harga', 'desc')
		->get();

		// dd($datas);

		if (count($datas) != 0) {
			foreach ($datas as $i => $row) {
				$monitoring[$i] = $row->sedia + $row->tambah;
			}
		}else{
			$nominal = DB::table('harga')
			->orderBy('harga', 'desc')
			->where('id_tipe', Auth::user()->tipe)
			->get();
			foreach ($nominal as $i => $hrg) {
				$monitoring[$i] = 0;
			}
		}

		// dd($monitoring);
		return view('sales.pdf_kasir')->with(['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'monitoring' => $monitoring]);
		// $pdf = PDF::loadview('sales.pdf_kasir',['id_laporan' => $id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'acc' => $acc, 'status' => $status, 'monitoring' => $monitoring]);
		// return $pdf->stream();
		
		// $nama_file = 'laporan_'.date('Y-m-d_H-i-s').'.pdf';
		// return Excel::download(new SinglePdf($id_laporan, $tgl_laporan, $nama), $nama_file,\Maatwebsite\Excel\Excel::DOMPDF);
	}
	
	public function cetakpdf(Request $request)
	{
		$from = $request->from;
		$to = $request->to;
		
		$data = DB::table('laporan')
		->where('id_user', '=', Auth::user()->id)
		->whereDate('tgl_laporan', '>=', $from)
		->whereDate('tgl_laporan', '<=', $to)
		->orderBy('tgl_laporan', 'desc')->get();
		
		for ($i=0; $i < count($data); $i++) { 
			$item = DB::table('item_laporan')
			->where('id_laporan', '=', $data[$i]->id_laporan)
			->get();
			$item_laporan[$i] = $item;

			$tgl = Carbon::parse($data[$i]->tgl_laporan)->translatedFormat('Y-m-d');

			$item = DB::table('item_monitoring')
			->where('id_user', $data[$i]->id_user)
			->whereDate('tgl_laporan', $tgl)
			->get();
			$item_monitoring[$i] = $item;
		}
		
		$pdf = PDF::loadview('sales.cetakpdf',['data' => $data, 'item_laporan' => $item_laporan, 'item_monitoring' => $item_monitoring]);
		return $pdf->stream();
	}
}