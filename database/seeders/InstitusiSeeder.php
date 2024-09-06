<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Dinas A',
                'alamat' => 'Jl. A',
            ],
            [
                'id' => 2,
                'nama' => 'Dinas B',
                'alamat' => 'Jl. B',
            ],
            [
                'id' => 3,
                'nama' => 'Dinas C',
                'alamat' => 'Jl. C',
            ],
            [
                'id' => 4,
                'nama' => 'Dinas D',
                'alamat' => 'Jl. D',
            ],
        ];
        DB::table('institusi')->insert($data);
    }
}
