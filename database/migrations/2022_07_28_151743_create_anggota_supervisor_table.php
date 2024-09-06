<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_supervisor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('profile_dpl');
            $table->bigInteger('profile_surveyor');
            $table->uuid('lokasi_survey_supervisor_id');
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
        Schema::dropIfExists('anggota_supervisor');
    }
}
