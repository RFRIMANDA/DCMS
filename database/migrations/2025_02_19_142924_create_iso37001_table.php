<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('iso37001', function (Blueprint $table) {
            $table->id();
            $table->string('id_divisi');
            $table->string('nama_proses');
            $table->string('potensi');
            $table->string('skema');
            $table->integer('s');
            $table->integer('p');
            $table->integer('level');
            $table->string('tindakan');
            $table->string('acuan');
            $table->integer('s2');
            $table->integer('p2');
            $table->integer('level2');
            $table->string('mitigasi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('iso37001');
    }
};

