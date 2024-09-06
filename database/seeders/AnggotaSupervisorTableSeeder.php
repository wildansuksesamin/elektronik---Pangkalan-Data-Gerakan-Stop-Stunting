<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AnggotaSupervisorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('anggota_supervisor')->delete();
        
        \DB::table('anggota_supervisor')->insert(array (
            0 => 
            array (
                'id' => '1cee08a7-8594-4eb5-ad32-54df662f2fb8',
                'profile_dpl' => 4,
                'profile_surveyor' => 6,
                'lokasi_survey_supervisor_id' => '943f2e76-625f-4ce4-9955-3d3f1b0ab4d5',
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 21:06:32',
                'updated_at' => '2022-07-28 21:06:32',
            ),
            1 => 
            array (
                'id' => '589b281b-f3b1-413b-a55d-9442e2f96c6c',
                'profile_dpl' => 4,
                'profile_surveyor' => 6,
                'lokasi_survey_supervisor_id' => '8b85626c-916e-47dd-8371-88e4c5035a9b',
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 20:52:22',
                'updated_at' => '2022-07-28 20:52:22',
            ),
            2 => 
            array (
                'id' => '5bf3dfdb-d5ea-4243-886c-b4db8c657805',
                'profile_dpl' => 4,
                'profile_surveyor' => 7,
                'lokasi_survey_supervisor_id' => '8b85626c-916e-47dd-8371-88e4c5035a9b',
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 20:52:25',
                'updated_at' => '2022-07-28 20:52:25',
            ),
        ));
        
        
    }
}