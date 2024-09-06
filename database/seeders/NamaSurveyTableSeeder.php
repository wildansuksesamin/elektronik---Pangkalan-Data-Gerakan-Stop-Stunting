<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NamaSurveyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('nama_survey')->delete();
        
        \DB::table('nama_survey')->insert(array (
            0 => 
            array (
                'id' => 6,
                'nama' => 'Pelatihan Review',
                'tipe' => 'Pre',
                'is_aktif' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-07-21 20:24:16',
                'updated_at' => '2022-07-21 20:24:16',
            ),
            1 => 
            array (
                'id' => 7,
                'nama' => 'Coba DPL',
                'tipe' => 'Pre',
                'is_aktif' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 20:47:11',
                'updated_at' => '2022-07-28 20:47:11',
            ),
        ));
        
        
    }
}