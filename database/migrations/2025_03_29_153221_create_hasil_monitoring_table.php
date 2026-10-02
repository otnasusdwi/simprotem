<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_monitoring', function (Blueprint $table) {
            $table->integer('id_hasil', true);
            $table->string('id_monitoring', 32);
            $table->dateTime('tgl_laporan');
            $table->double('harga');
            $table->double('sedia')->default(0);
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
        Schema::dropIfExists('hasil_monitoring');
    }
}
