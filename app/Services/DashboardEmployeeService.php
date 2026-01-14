<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class DashboardEmployeeService
{
    public function create(array $data): Employee
    {
        $employee = Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
        ]);
        return $employee;
    }

    public function update(array $data, Employee $employee): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $employee->update($data);
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }

    public function getAll()
    {
        return Employee::where('role_id', '!=', 1)->orderBy('role_id');
    }
}
