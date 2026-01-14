<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Super Admin',
        ]);
        Role::create([
            'role_name' => 'Data Entry',
        ]);
        Role::create([
            'role_name' => 'Order Validater',
        ]);
        Role::create([
            'role_name' => 'Shipping Representative',
        ]);
        Role::create([
            'role_name' => 'Support Team',
        ]);
    }
}
