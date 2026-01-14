<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fabric;

class FabricSeeder extends Seeder
{
    public function run(): void
    {
        $fabrics = ['Cotton', 'Linen', 'Leather', 'Velvet', 'Polyester'];
        foreach ($fabrics as $fabric) {
            Fabric::create(['fabric_type' => $fabric]);
        }
    }
}
