<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetCodesTable extends Migration
{
    public function up()
    {
        Schema::create('budget_codes', function (Blueprint $table) {
            $table->integer('Kode_Anggaran')->primary();
            $table->string('Nama_Anggaran', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_codes');
    }
}