<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSyncMonitoring extends Model
{
    protected $table = 'log_sync_monitoring';
    protected $fillable = [
        'start_date', // Tanggal awal sinkronisasi
        'end_date',   // Tanggal akhir sinkronisasi
        'total_data', // Total data yang disinkronkan
        'status'      // Status sinkronisasi (misalnya: sukses/gagal)
    ];
}
