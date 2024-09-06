<?php

namespace Database\Seeders;

use App\Models\Responden;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RespondenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Responden::factory(15);
        // die;
        $data = [
            [
                'id' => 1,
                'kartu_keluarga' => 72060907099700001,
                'nama_kepala_keluarga' => 'Angga',
                'alamat' => 'Jl. Pertama',
                'provinsi_id' => 73,
                'kabupaten_kota_id' => 7373,
                'kecamatan_id' => 7373020,
                'desa_kelurahan_id' => 7373020003,
                'nomor_hp' => '082298979292',
                'kode_unik' => '11223344',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'kartu_keluarga' => 88960907099700788,
                'nama_kepala_keluarga' => 'Febri',
                'alamat' => 'Jl. Kedua',
                'provinsi_id' => 72,
                'kabupaten_kota_id' => 7203,
                'kecamatan_id' => 7203041,
                'desa_kelurahan_id' => 7203041003,
                'nomor_hp' => '082299078787',
                'kode_unik' => '22334411',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'kartu_keluarga' => 66770907099705432,
                'nama_kepala_keluarga' => 'Boy',
                'alamat' => 'Jl. Ketiga',
                'provinsi_id' => 73,
                'kabupaten_kota_id' => 7313,
                'kecamatan_id' => 7313120,
                'desa_kelurahan_id' => 7313120006,
                'nomor_hp' => '082299078787',
                'kode_unik' => '33221188',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        DB::table('responden')->insert($data);
    }
}
