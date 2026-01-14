<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Wood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'available_quantity' => $this->faker->numberBetween(0, 100),
            'category_id' => Category::factory(),
            'color_id' => Color::factory(),
            'fabric_id' => Fabric::factory(),
            'wood_id' => Wood::factory(),
            '3D_model' => 'default_model.glb',
        ];
    }
}