<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'detail' => fake()->text(),
            'image' => fake()->imageUrl($width = 640, $height = 480),
            'prix' => fake()->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 30), 
            'quantite' => fake()->randomNumber($nbDigits = NULL, $strict = false),
        ];
    }
}
