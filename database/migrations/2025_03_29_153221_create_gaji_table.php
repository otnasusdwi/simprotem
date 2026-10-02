<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_karyawan', 32);
            $table->string('tgl_gaji', 32);
            $table->string('bulan', 50);
            $table->string('tahun', 50);
            $table->double('masuk')->default(0);
            $table->double('gaji_karyawan')->default(0);
            $table->double('hutang')->default(0);
            $table->double('jaga_malam')->default(0);
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
        Schema::dropIfExists('gaji');
    }
}
