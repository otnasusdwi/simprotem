<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateTableSetorBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setor_bank', function (Blueprint $table) {
            $table->id();
            $table->date('tgl');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('id_pengeluaran')->nullable();
            $table->date('tgl_setor')->nullable();
            $table->double('uang_masuk', 15, 2)->nullable();
            $table->double('pengeluaran', 15, 2)->nullable();
            $table->double('setor_bank', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pengeluaran')->references('id')->on('pengeluaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setor_bank');
    }
}
