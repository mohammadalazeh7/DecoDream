<?php

namespace App\Services;

use App\Models\Fabric;



class DashboardFabricService
{
    public function create(array $data)
    {
        return Fabric::create([
            'fabric_type' => $data['fabric_type']
        ]);
    }

    public function update(array $data, Fabric $fabric)
    {
        return $fabric->update($data);
    }

    public function delete(Fabric $fabric)
    {

        // if ($fabric->products()->count() > 0) {
        //     return false;
        // }

        return $fabric->delete();

    }

    public function getAll()
    {
        return Fabric::query()
            ->whereNull('deleted_at')  // تجاهل المحذوفين
            ->orderBy('id', 'asc');
    }
}
