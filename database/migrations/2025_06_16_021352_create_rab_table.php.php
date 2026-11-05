<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRabTable extends Migration
{
    public function up()
    {
        Schema::create('rab', function (Blueprint $table) {
            $table->string('NOMOR_RAB', 10)->primary();
            $table->string('Kegiatan', 50);
            $table->date('TANGGAL_RAP');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rab');
    }
}