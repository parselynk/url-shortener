<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shortcode_uuid' => $this->faker->uuid(),
            'redirect_url' => $this->faker->url(),
            'active' => $this->faker->boolean(),
        ];
    }
}
