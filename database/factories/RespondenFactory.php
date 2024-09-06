<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RespondenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kartu_keluarga' => $this->faker->nik(),
            'alamat' => $this->faker->address(),
            'provinsi_id' => 72,
            'kabupaten_kota_id' => 7203,
            'kecamatan_id' => 7203041,
            'desa_kelurahan_id' => 7203041003,
            'nomor_hp' => '082299078787',
        ];
    }
}
