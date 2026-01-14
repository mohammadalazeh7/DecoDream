<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Green', 'Black', 'White', 'Brown'];
        foreach ($colors as $color) {
            Color::create(['name' => $color]);
        }
    }
}
