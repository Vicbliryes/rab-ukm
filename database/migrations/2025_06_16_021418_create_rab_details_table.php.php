<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('rab_details', function (Blueprint $table) {
            $table->id();
            $table->string('NOMOR_RAB', 10);
            $table->integer('Kode_Anggaran');
            $table->string('Nama', 100);
            $table->integer('Jumlah');
            $table->string('Satuan', 20);
            $table->decimal('Harga_Satuan', 15, 2);
            $table->foreign('NOMOR_RAB')->references('NOMOR_RAB')->on('rab');
            $table->foreign('Kode_Anggaran')->references('Kode_Anggaran')->on('budget_codes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rab_details');
    }
}