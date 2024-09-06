<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSurveyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('lokasi_survey')->delete();
        
        DB::table('lokasi_survey')->insert(array (
            0 => 
            array (
                'created_at' => '2022-07-28 00:47:11',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080022,
                'id' => '0e77534a-a0f6-4806-8dc6-bfee0ec479cb',
                'nama_lokasi_survey' => 'Posko 8',
                'updated_at' => '2022-07-28 00:47:11',
            ),
            1 => 
            array (
                'created_at' => '2022-07-28 00:44:36',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080014,
                'id' => '217b2686-b74a-4007-91c5-fdd83a265965',
                'nama_lokasi_survey' => 'Posko 3',
                'updated_at' => '2022-07-28 00:44:36',
            ),
            2 => 
            array (
                'created_at' => '2022-07-28 00:49:02',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080028,
                'id' => '2cf42cd0-c248-49bc-9134-9c09b544c659',
                'nama_lokasi_survey' => 'Posko 12',
                'updated_at' => '2022-07-28 00:49:45',
            ),
            3 => 
            array (
                'created_at' => '2022-07-28 00:43:41',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080013,
                'id' => '4246db15-d078-4e07-99cf-c0d33d5e72bb',
                'nama_lokasi_survey' => 'Posko 1',
                'updated_at' => '2022-07-28 00:43:41',
            ),
            4 => 
            array (
                'created_at' => '2022-07-28 00:44:11',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080031,
                'id' => '5e8813ea-07c0-4fa1-a3a2-5b2378fcbe87',
                'nama_lokasi_survey' => 'Posko 2',
                'updated_at' => '2022-07-28 00:44:11',
            ),
            5 => 
            array (
                'created_at' => '2022-07-28 00:46:16',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080023,
                'id' => '7c4495f6-1247-4fa9-8afe-c9848eadd398',
                'nama_lokasi_survey' => 'Posko 6',
                'updated_at' => '2022-07-28 00:46:16',
            ),
            6 => 
            array (
                'created_at' => '2022-07-28 00:47:46',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080024,
                'id' => '7ce1b933-ca64-4c6c-b696-091446362a7f',
                'nama_lokasi_survey' => 'Posko 9',
                'updated_at' => '2022-07-28 00:47:46',
            ),
            7 => 
            array (
                'created_at' => '2022-07-28 00:45:00',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080029,
                'id' => '85838d60-bb9e-44b9-8460-877f357f7614',
                'nama_lokasi_survey' => 'Posko 4',
                'updated_at' => '2022-07-28 00:45:00',
            ),
            8 => 
            array (
                'created_at' => '2022-07-28 00:48:34',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080025,
                'id' => 'bc3ecbd9-50a5-44a3-b3ee-e82f27ab20c6',
                'nama_lokasi_survey' => 'Posko 11',
                'updated_at' => '2022-07-28 00:48:34',
            ),
            9 => 
            array (
                'created_at' => '2022-07-28 00:45:40',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080030,
                'id' => 'be4b5116-9f82-4b08-8fd6-f3d1910bb62e',
                'nama_lokasi_survey' => 'Posko 5',
                'updated_at' => '2022-07-28 00:45:40',
            ),
            10 => 
            array (
                'created_at' => '2022-07-28 00:46:43',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080020,
                'id' => 'dfc9fa26-f31d-439e-bb79-0e5ba7e6f5bf',
                'nama_lokasi_survey' => 'Posko 7',
                'updated_at' => '2022-07-28 00:46:43',
            ),
            11 => 
            array (
                'created_at' => '2022-07-28 00:48:14',
                'deleted_at' => NULL,
                'desa_kelurahan_id' => 7205080026,
                'id' => 'e2657e62-7d29-42fe-bd36-90aea75d5603',
                'nama_lokasi_survey' => 'Posko 10',
                'updated_at' => '2022-07-28 00:48:14',
            ),
        ));
        
        
    }
}
