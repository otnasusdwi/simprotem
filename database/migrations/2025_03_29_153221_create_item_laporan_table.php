<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemLaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_laporan', function (Blueprint $table) {
            $table->integer('id_item_laporan', true);
            $table->string('id_laporan', 32);
            $table->double('harga');
            $table->double('bawa')->nullable();
            $table->double('tambah')->default(0);
            $table->double('laku')->nullable();
            $table->double('sisa_muda')->nullable();
            $table->double('sisa_tua')->nullable();
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
        Schema::dropIfExists('item_laporan');
    }
}
