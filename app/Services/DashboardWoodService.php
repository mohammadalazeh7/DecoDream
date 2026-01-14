<?php

namespace App\Services;

use App\Models\Wood;

class DashboardWoodService
{
    public function create(array $data)
    {
        return Wood::create([
            'wood_type' => $data['wood_type']
        ]);
    }

    public function update(array $data, Wood $wood)
    {
        return $wood->update($data);
    }

    public function delete(Wood $wood)
    {
        //    if ($wood->products()->count() > 0) {
        //         return false;
        //     }
        return $wood->delete();
    }


    public function getAll()
    {
        return Wood::query()
            ->whereNull('deleted_at')  // تجاهل المحذوفين
            ->orderBy('id', 'asc');
    }
}
