<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_survey', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('soal_id');
            $table->bigInteger('kode_unik_survey');
            $table->bigInteger('kategori_soal_id');
            $table->bigInteger('jawaban_soal_id')->nullable()->default(null);
            $table->text('jawaban_lainnya')->nullable()->default(null);
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
        Schema::dropIfExists('jawaban_survey');
    }
}
