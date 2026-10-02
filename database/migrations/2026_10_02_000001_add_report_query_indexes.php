<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->index('tgl_laporan', 'laporan_tgl_laporan_index');
            $table->index(['id_user', 'tgl_laporan'], 'laporan_user_tanggal_index');
            $table->index(['id_tipe', 'tgl_laporan'], 'laporan_tipe_tanggal_index');
            $table->index('status', 'laporan_status_index');
        });

        Schema::table('item_laporan', function (Blueprint $table) {
            $table->index('id_laporan', 'item_laporan_laporan_index');
        });

        Schema::table('item_monitoring', function (Blueprint $table) {
            $table->index(['id_user', 'tgl_laporan'], 'item_monitoring_user_tanggal_index');
        });
    }

    public function down(): void
    {
        Schema::table('item_monitoring', function (Blueprint $table) {
            $table->dropIndex('item_monitoring_user_tanggal_index');
        });

        Schema::table('item_laporan', function (Blueprint $table) {
            $table->dropIndex('item_laporan_laporan_index');
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->dropIndex('laporan_tgl_laporan_index');
            $table->dropIndex('laporan_user_tanggal_index');
            $table->dropIndex('laporan_tipe_tanggal_index');
            $table->dropIndex('laporan_status_index');
        });
    }
};
