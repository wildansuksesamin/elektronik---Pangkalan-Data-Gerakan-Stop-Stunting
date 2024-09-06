<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 2;
        static $user_id = 2;
        return [
            'id' => $id++,
            'user_id' => $user_id++,
            'nama_lengkap' => $this->faker->name,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),    
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'provinsi' => 72,
            'kabupaten_kota' => 7271,
            'kecamatan' => 7271031,
            'desa_kelurahan' => 7271031005,
            'nomor_hp' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];
    }
}
