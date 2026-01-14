<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wood;

class WoodSeeder extends Seeder
{
    public function run(): void
    {
        $woods = ['Oak', 'Pine', 'Walnut', 'Maple', 'Cherry'];
        foreach ($woods as $wood) {
            Wood::create(['wood_type' => $wood]);
        }
    }
}
