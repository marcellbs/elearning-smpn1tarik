<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kode_siswa');
            $table->enum('status', ['S', 'H', 'I', 'A', 'K'])->default('H');
            $table->date('tanggal_presensi');
            $table->unsignedBigInteger('kode_guru');
            $table->timestamps();

            $table->foreign('kode_siswa')->references('kode_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
}
