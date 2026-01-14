<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class DashboardCategoryService
{
    public function create(array $data): Category
    {
        $categoryData = ['name' => $data['name']];

        // Handle icon upload
        if (isset($data['icon']) && $data['icon']) {
            $iconPath = $data['icon']->store('category-icons', 'public');
            $categoryData['icon'] = basename($iconPath);
        }

        return Category::create($categoryData);
    }

    public function update(array $data, Category $category)
    {
        $updateData = ['name' => $data['name']];

        // Handle icon upload
        if (isset($data['icon']) && $data['icon']) {
            // Delete old icon if exists
            if ($category->icon) {
                $oldIconPath = 'category-icons/' . $category->icon;
                if (Storage::disk('public')->exists($oldIconPath)) {
                    Storage::disk('public')->delete($oldIconPath);
                }
            }

            // Store new icon
            $iconPath = $data['icon']->store('category-icons', 'public');
            $updateData['icon'] = basename($iconPath);
        }

        return $category->update($updateData);
    }

    public function delete(Category $category): bool
    {
        // if ($category->products()->count() > 0) {
        //     return false;
        // }

        // Delete icon file if exists
        // if ($category->icon) {
        //     $iconPath = 'category-icons/' . $category->icon;
        //     if (Storage::disk('public')->exists($iconPath)) {
        //         Storage::disk('public')->delete($iconPath);
        //     }
        // }

        return $category->delete();
    }

    public function getAll()
    {
        return Category::query()
            ->whereNull('deleted_at')  // تجاهل المحذوفين
            ->orderBy('id', 'asc');
    }

}
