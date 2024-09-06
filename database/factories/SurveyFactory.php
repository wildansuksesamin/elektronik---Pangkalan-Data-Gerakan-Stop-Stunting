<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'responden_id' => $this->faker->numberBetween(1, 1000),
            'nama_survey_id' => $this->faker->numberBetween(1, 50),
            'profile_id' => $this->faker->numberBetween(1, 50),
            'kategori_selanjutnya' => NULL,
            'is_selesai' => 1,
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
