<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InstitusiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('institusi')->delete();
        
        \DB::table('institusi')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama' => 'Dinas P2KB',
                'alamat' => NULL,
                'created_at' => NULL,
                'updated_at' => '2022-07-22 14:25:13',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 5,
                'nama' => 'Universitas Tadulako',
                'alamat' => NULL,
                'created_at' => '2022-07-10 18:16:13',
                'updated_at' => '2022-07-10 18:16:13',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 6,
                'nama' => 'Universitas Alkhairaat',
                'alamat' => NULL,
                'created_at' => '2022-07-10 18:16:48',
                'updated_at' => '2022-07-10 18:16:58',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 7,
                'nama' => 'Universitas Muhammadiyah Palu',
                'alamat' => NULL,
                'created_at' => '2022-07-11 16:24:01',
                'updated_at' => '2022-07-11 16:24:01',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 8,
                'nama' => 'STIK Indonesia Jaya Palu',
                'alamat' => NULL,
                'created_at' => '2022-07-11 16:24:10',
                'updated_at' => '2022-07-11 16:24:10',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 9,
                'nama' => 'POLITEKNIK KESEHATAN PALU',
                'alamat' => NULL,
                'created_at' => '2022-07-12 12:45:54',
                'updated_at' => '2022-07-12 12:45:54',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 10,
                'nama' => 'BKKBN Provinsi Sulawesi Tengah',
                'alamat' => NULL,
                'created_at' => '2022-07-12 13:51:03',
                'updated_at' => '2022-07-22 14:26:23',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}