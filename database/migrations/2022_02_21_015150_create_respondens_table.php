<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responden', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kartu_keluarga');
            $table->string('nama_kepala_keluarga');
            $table->text('alamat');
            $table->bigInteger('provinsi_id');
            $table->bigInteger('kabupaten_kota_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('desa_kelurahan_id');
            $table->string('nomor_hp')->nullable();
            $table->integer('kode_unik');
            $table->softDeletes();
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
        Schema::dropIfExists('responden');
    }
}
