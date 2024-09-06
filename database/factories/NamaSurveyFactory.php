<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NamaSurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipe = array('Pre', 'Post');
        static $id = 2;
        return [
            'id' => $id++,
            'nama' => $this->faker->sentence(2),
            'tipe' => $tipe[array_rand($tipe)]
        ];
    }
}
