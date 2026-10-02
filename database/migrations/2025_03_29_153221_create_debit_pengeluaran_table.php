<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_pengeluaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl');
            $table->string('id_pengeluaran', 32);
            $table->date('tgl_setor')->nullable();
            $table->double('debit');
            $table->double('kredit');
            $table->text('ket')->nullable();
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
        Schema::dropIfExists('debit_pengeluaran');
    }
}
