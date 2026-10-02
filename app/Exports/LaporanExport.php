<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Harga;
use App\Models\Tipe;
use App\Models\Laporan;
use App\Models\ItemLaporan;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    public function __construct(string $id_user, string $id_tipe, string $from, string $to)
    {
        $this->id_user = $id_user;
        $this->id_tipe = $id_tipe;
        $this->from = $from;
        $this->to = $to;
    }
    public function view(): View
    {
        $q = DB::table('laporan')
        ->join('users', 'laporan.id_user', '=', 'users.id')
        ->select('laporan.*', 'users.name', 'users.piutang');

        if($this->from){
            $q->whereDate('laporan.tgl_laporan', '>=', $this->from)
            ->whereDate('laporan.tgl_laporan', '<=', $this->to);
        }else{
            $now = Carbon::now();
            $month = $now->month;
            $q->whereMonth('laporan.tgl_laporan', '=', $month);
        }
        
        if($this->id_user != 'NULL'){
            $q->where('laporan.id_user', $this->id_user);
        }
        
        if($this->id_tipe != 'NULL'){
            $q->where('laporan.id_tipe', $this->id_tipe);
        }

        $laporan = $q->orderBy('laporan.tgl_laporan', 'asc')->get();

        // dd($laporan);

        // for ($i=0; $i < count($laporan); $i++) {
		// 	$item = DB::table('item_laporan')
		// 	->where('id_laporan', $laporan[$i]->id_laporan)
		// 	->orderBy('harga', 'desc')
		// 	->get()->toArray();

		// 	if ($item != NULL) {
		// 		$item_laporan[$i] = $item;
		// 	}
		// }

        // dd($item_laporan);
        
        $item_laporan = DB::table('item_laporan')
        ->orderBy('harga', 'desc')
        ->get();
        
        $harga = DB::table('harga')
        ->where('id_tipe', '=', $this->id_tipe)
        ->orderBy('harga', 'desc')
        ->get();

        $tipe = DB::table('tipe')
        ->orderBy('tipe', 'asc')
        ->get();
        
        return view('admin.laporan.cetak')->with(['laporan' => $laporan, 'item_laporan' => $item_laporan, 'harga' => $harga, 'tipe' => $tipe]);
    }
}