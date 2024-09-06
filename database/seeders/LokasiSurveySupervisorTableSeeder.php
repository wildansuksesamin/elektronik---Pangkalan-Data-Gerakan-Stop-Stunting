<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LokasiSurveySupervisorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lokasi_survey_supervisor')->delete();
        
        \DB::table('lokasi_survey_supervisor')->insert(array (
            0 => 
            array (
                'id' => '8b85626c-916e-47dd-8371-88e4c5035a9b',
                'profile_id' => 4,
                'lokasi_survey_id' => '4246db15-d078-4e07-99cf-c0d33d5e72bb',
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 20:52:16',
                'updated_at' => '2022-07-28 20:52:16',
            ),
            1 => 
            array (
                'id' => '943f2e76-625f-4ce4-9955-3d3f1b0ab4d5',
                'profile_id' => 4,
                'lokasi_survey_id' => 'e2657e62-7d29-42fe-bd36-90aea75d5603',
                'deleted_at' => NULL,
                'created_at' => '2022-07-28 21:02:58',
                'updated_at' => '2022-07-28 21:02:58',
            ),
        ));
        
        
    }
}