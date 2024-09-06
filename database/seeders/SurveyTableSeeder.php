<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SurveyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('survey')->delete();
        
        \DB::table('survey')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kode_unik_responden' => 89086354,
                'nama_survey_id' => 7,
                'profile_id' => 6,
                'kategori_selanjutnya' => NULL,
                'is_selesai' => 1,
                'kode_unik' => 13716242,
                'created_at' => '2022-07-28 20:48:56',
                'updated_at' => '2022-07-28 20:49:07',
            ),
            1 => 
            array (
                'id' => 2,
                'kode_unik_responden' => 83905443,
                'nama_survey_id' => 7,
                'profile_id' => 7,
                'kategori_selanjutnya' => NULL,
                'is_selesai' => 1,
                'kode_unik' => 40318097,
                'created_at' => '2022-07-28 20:49:27',
                'updated_at' => '2022-07-28 20:49:35',
            ),
            2 => 
            array (
                'id' => 3,
                'kode_unik_responden' => 82785054,
                'nama_survey_id' => 7,
                'profile_id' => 8,
                'kategori_selanjutnya' => NULL,
                'is_selesai' => 1,
                'kode_unik' => 89982535,
                'created_at' => '2022-07-29 10:38:52',
                'updated_at' => '2022-07-29 10:38:59',
            ),
            3 => 
            array (
                'id' => 4,
                'kode_unik_responden' => 68896512,
                'nama_survey_id' => 7,
                'profile_id' => 9,
                'kategori_selanjutnya' => NULL,
                'is_selesai' => 1,
                'kode_unik' => 59308567,
                'created_at' => '2022-07-29 10:39:18',
                'updated_at' => '2022-07-29 10:39:27',
            ),
        ));
        
        
    }
}