<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = $this->faker->dateTime('now');
        return [
            'id' => rand(0, 100000),
            'shortcode_uuid' => Str::random(5),
            'redirect_url' => $this->faker->url(),
            'hit_count' => $this->faker->randomDigit(),
            'active' => $this->faker->boolean(),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
