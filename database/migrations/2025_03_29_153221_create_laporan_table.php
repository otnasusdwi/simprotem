<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->string('id_laporan', 32)->primary();
            $table->string('id_user', 50);
            $table->string('id_tipe', 50);
            $table->dateTime('tgl_laporan');
            $table->double('hutang_baru')->nullable();
            $table->double('pelunasan')->nullable();
            $table->double('jumlah_laku');
            $table->double('marginsales');
            $table->double('piutang');
            $table->double('setoran');
            $table->string('status', 10)->default('0');
            $table->dateTime('acc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan');
    }
}
