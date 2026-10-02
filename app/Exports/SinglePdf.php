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

class SinglePdf implements FromView
{
    public function __construct(string $id_laporan)
    {
        $this->id_laporan = $id_laporan;
    }
    public function view(): View
    {
        $data = DB::table('item_laporan')
        ->join('laporan', 'item_laporan.id_laporan', '=', 'laporan.id_laporan')
        ->where('laporan.id_laporan', $this->id_laporan)
        ->select('item_laporan.*', 'laporan.jumlah_laku', 'laporan.marginsales', 'laporan.setoran', 'laporan.hutang_baru', 'laporan.pelunasan', 'laporan.piutang', 'laporan.status', 'laporan.tgl_laporan')
        ->get();
        
        $tgl_laporan = $data[0]->tgl_laporan;
        $status = $data[0]->status;
        
        return view('admin.laporan.pdf')->with(['id_laporan' => $this->id_laporan, 'data' => $data, 'tgl_laporan' => $tgl_laporan, 'status' => $status]);
    }
}