<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_monitoring', function (Blueprint $table) {
            $table->integer('id_item_monitoring', true);
            $table->string('id_monitoring', 50);
            $table->dateTime('tgl_laporan');
            $table->string('id_user', 30);
            $table->string('id_tipe', 30)->nullable();
            $table->double('harga');
            $table->double('sedia');
            $table->double('laku')->default(0);
            $table->double('tambah')->default(0);
            $table->double('tambah_sales')->default(0);
            $table->double('sisa_muda')->default(0);
            $table->double('sisa_tua')->default(0);
            $table->double('muda')->default(0);
            $table->double('tua')->default(0);
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
        Schema::dropIfExists('item_monitoring');
    }
}
