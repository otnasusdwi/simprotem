<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl');
            $table->string('id_sales', 32);
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
        Schema::dropIfExists('debit_sales');
    }
}
