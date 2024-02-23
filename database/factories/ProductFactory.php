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
        // return [
        //     'name' => fake()->name(),
        //     'detail' => fake()->text(),
        //     'image' => fake()->imageUrl($width = 640, $height = 480),
        //     'prix' => fake()->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 30), 
        //     'quantite' => fake()->randomNumber($nbDigits = NULL, $strict = false),
        // ];
        $prduct_name = $this->faker->unique()->words($nb = 2, $asText = true);
        $slug = Str::slug($prduct_name);
        $image_name = $this->faker->numberBetween(1, 24) . '.jpg';
        return [
            'name' => Str::title($prduct_name),
            'slug' => $slug,
            'short_description' => $this->faker->text(200),
            'description' => $this->faker->text(500),
            'regular_price' => $this->faker->numberBetween(1, 22),
            'SKU' => 'SMD' . $this->faker->numberBetween(100, 500),
            'stock_status' => 'instock',
            'quantity' => $this->faker->numberBetween(100, 200),
            'image' => $image_name,
            'images' => $image_name,
            'category_id' => $this->faker->numberBetween(1, 6),
            'brand_id' => $this->faker->numberBetween(1, 6)
        ];
    }
}
