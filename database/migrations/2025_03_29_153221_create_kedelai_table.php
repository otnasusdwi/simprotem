<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKedelaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kedelai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bulan', 32);
            $table->string('tahun', 32);
            $table->string('tgl', 32);
            $table->double('tempe')->default(0);
            $table->double('datang')->default(0);
            $table->double('sisa')->default(0);
            $table->double('sisa_lalu')->default(0);
            $table->double('harga')->default(0);
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
        Schema::dropIfExists('kedelai');
    }
}
