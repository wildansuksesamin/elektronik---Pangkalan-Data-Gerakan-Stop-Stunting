<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JawabanSurveyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jawaban_survey')->delete();
        
        \DB::table('jawaban_survey')->insert(array (
            0 => 
            array (
                'id' => 1,
                'soal_id' => 429,
                'kode_unik_survey' => 13716242,
                'kategori_soal_id' => 47,
                'jawaban_soal_id' => NULL,
                'jawaban_lainnya' => 'Amirul Hidayah',
                'created_at' => '2022-07-28 20:49:07',
                'updated_at' => '2022-07-28 20:49:07',
            ),
            1 => 
            array (
                'id' => 2,
                'soal_id' => 429,
                'kode_unik_survey' => 40318097,
                'kategori_soal_id' => 47,
                'jawaban_soal_id' => NULL,
                'jawaban_lainnya' => 'Jack U',
                'created_at' => '2022-07-28 20:49:35',
                'updated_at' => '2022-07-28 20:49:35',
            ),
            2 => 
            array (
                'id' => 3,
                'soal_id' => 429,
                'kode_unik_survey' => 89982535,
                'kategori_soal_id' => 47,
                'jawaban_soal_id' => NULL,
                'jawaban_lainnya' => 'Naruto',
                'created_at' => '2022-07-29 10:38:59',
                'updated_at' => '2022-07-29 10:38:59',
            ),
            3 => 
            array (
                'id' => 4,
                'soal_id' => 429,
                'kode_unik_survey' => 59308567,
                'kategori_soal_id' => 47,
                'jawaban_soal_id' => NULL,
                'jawaban_lainnya' => 'Doraemon',
                'created_at' => '2022-07-29 10:39:27',
                'updated_at' => '2022-07-29 10:39:27',
            ),
        ));
        
        
    }
}