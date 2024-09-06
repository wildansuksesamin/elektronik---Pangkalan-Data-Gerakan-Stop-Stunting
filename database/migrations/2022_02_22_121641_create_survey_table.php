<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_unik_responden');
            $table->bigInteger('nama_survey_id');
            $table->bigInteger('profile_id');
            $table->bigInteger('kategori_selanjutnya')->default(null)->nullable();
            $table->bigInteger('is_selesai')->default(0);
            $table->integer('kode_unik');
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
        Schema::dropIfExists('survey');
    }
}
