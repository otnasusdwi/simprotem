<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKulitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kulit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl');
            $table->string('id_pelanggan', 32);
            $table->double('kulit');
            $table->double('harga');
            $table->double('bayar')->default(0);
            $table->double('tagihan')->default(0);
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
        Schema::dropIfExists('kulit');
    }
}
