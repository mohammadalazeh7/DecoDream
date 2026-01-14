<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Employee::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
        Employee::create([
            'name' => 'Data Entry',
            'email' => 'dataentry@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);
        Employee::create([
            'name' => 'Order Validater',
            'email' => 'ordervalidater@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);

        Employee::create([
            'name' => 'Shipping representative',
            'email' => 'shippingrepresentative@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 4,
        ]);
        Employee::create([
            'name' => 'jad',
            'email' => 'jad@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 4,
        ]);
        Employee::create([
            'name' => 'jafar',
            'email' => 'jafar@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 4,
        ]);

        Employee::create([
            'name' => 'Support team',
            'email' => 'supportteam@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 5,
        ]);



    }
}
