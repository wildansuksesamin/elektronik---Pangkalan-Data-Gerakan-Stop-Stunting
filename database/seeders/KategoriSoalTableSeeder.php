<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KategoriSoalTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kategori_soal')->delete();
        
        \DB::table('kategori_soal')->insert(array (
            0 => 
            array (
                'id' => 40,
                'urutan' => 1,
                'nama' => 'Demografi',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 20:24:31',
                'updated_at' => '2022-07-21 20:24:31',
            ),
            1 => 
            array (
                'id' => 41,
                'urutan' => 2,
                'nama' => 'Faktor Pengetahuan',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 20:45:34',
                'updated_at' => '2022-07-21 20:45:34',
            ),
            2 => 
            array (
                'id' => 42,
                'urutan' => 3,
                'nama' => 'Faktor Sosial Budaya',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 20:55:20',
                'updated_at' => '2022-07-21 20:55:20',
            ),
            3 => 
            array (
                'id' => 43,
                'urutan' => 4,
                'nama' => 'Faktor Ekonomi',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 21:03:06',
                'updated_at' => '2022-07-21 21:03:06',
            ),
            4 => 
            array (
                'id' => 44,
                'urutan' => 5,
                'nama' => 'Faktor Lingkungan',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 21:12:03',
                'updated_at' => '2022-07-21 21:12:03',
            ),
            5 => 
            array (
                'id' => 45,
                'urutan' => 6,
                'nama' => 'Faktor Kesehatan',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 21:47:11',
                'updated_at' => '2022-07-21 21:47:11',
            ),
            6 => 
            array (
                'id' => 46,
                'urutan' => 7,
                'nama' => 'Faktor Psikologi',
                'nama_survey_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 22:52:52',
                'updated_at' => '2022-07-21 22:52:52',
            ),
            7 => 
            array (
                'id' => 47,
                'urutan' => 1,
                'nama' => 'Biografi',
                'nama_survey_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}