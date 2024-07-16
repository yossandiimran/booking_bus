<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bus', function (Blueprint $table) {
            $table->id();
            $table->string('bus');
            $table->string('nopol');
            $table->integer('jumlah_kursi');
            $table->integer('tarif');
            $table->text('foto');
            $table->string('type_bus');
            $table->date('status')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('id_sopir');
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
        Schema::dropIfExists('master_bus');
    }
}
