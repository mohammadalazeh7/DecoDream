<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Wood;
use Faker\Factory as Faker;
class ProductSeeder extends Seeder
{
    public function run(): void
    {

            $faker = Faker::create();
            $categories = Category::pluck('id')->all();
            $colors = Color::pluck('id')->all();
            $fabrics = Fabric::pluck('id')->all();
            $woods = Wood::pluck('id')->all();

            $names = ['Modern Sofa', 'Classic Chair', 'Wooden Table', 'Luxury Bed', 'Office Desk', 'Bookshelf', 'Dining Table', 'Recliner', 'TV Stand', 'Wardrobe'];

            foreach ($names as $name) {
                Product::create([
                    'name' => $name,
                    'price' => $faker->randomFloat(2, 100, 2000),
                    'description' => $faker->sentence(8),
                    'available_quantity' => $faker->numberBetween(1, 50),
                    'category_id' => $faker->randomElement($categories),
                    'color_id' => $faker->randomElement($colors),
                    'fabric_id' => $faker->randomElement($fabrics),
                    'wood_id' => $faker->randomElement($woods),
                ]);
            }

    }
}
