<?php


namespace App\Services;

use App\Models\Product;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class DashboardProductServies
{


    public function create(array $data): Product
    {
        // إنشاء المنتج الأساسي
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'available_quantity' => $data['available_quantity'],
            'category_id' => $data['category_id'],
            'color_id' => $data['color_id'],
            'fabric_id' => $data['fabric_id'],
            'wood_id' => $data['wood_id'],
            // '3d_model' => $data['3d_model'] ?? null,
        ]);

        // إضافة الصور
        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $path = $image->store('products/' . $product->id, 'public');
                $product->photos()->create(['photo' => $path]);
            }
        }

        return $product;
    }

    public function update(Product $product, array $data): bool
    {
        try {
            // تحديث المنتج الأساسي
            $product->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'available_quantity' => $data['available_quantity'],
                'category_id' => $data['category_id'],
                'color_id' => $data['color_id'] ?? null,
                'fabric_id' => $data['fabric_id'] ?? null,
                'wood_id' => $data['wood_id'] ?? null,
                '3d_model' => $data['3d_model'] ?? null,
            ]);

            // معالجة حذف الصور المحددة
            if (isset($data['photos_to_delete']) && !empty($data['photos_to_delete'])) {
                $this->deleteSelectedPhotos($product, $data['photos_to_delete']);
            }

            // إضافة الصور الجديدة
            if (isset($data['images']) && !empty($data['images'])) {
                $this->addNewPhotos($product, $data['images']);
            }

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error updating product: ' . $e->getMessage());
        }
    }

    /**
     * حذف الصور المحددة
     */
    private function deleteSelectedPhotos(Product $product, string $photosToDelete): void
    {
        $photoIds = explode(',', $photosToDelete);
        $photoIds = array_filter($photoIds); // إزالة القيم الفارغة

        if (!empty($photoIds)) {
            // الحصول على الصور المحددة للحذف
            $photos = Photo::whereIn('id', $photoIds)
                ->where('product_id', $product->id)
                ->get();

            foreach ($photos as $photo) {
                // حذف الملف من التخزين
                if (Storage::disk('public')->exists($photo->photo)) {
                    Storage::disk('public')->delete($photo->photo);
                }

                // حذف السجل من قاعدة البيانات
                $photo->delete();
            }
        }
    }

    /**
     * إضافة صور جديدة
     */
    private function addNewPhotos(Product $product, array $images): void
    {
        foreach ($images as $image) {
            $path = $image->store('products/' . $product->id, 'public');
            $product->photos()->create(['photo' => $path]);
        }
    }

    public function delete(Product $product): bool
    {
        try {
            // حذف الصور المرتبطة بالمنتج من التخزين
            $photos = $product->photos;
            foreach ($photos as $photo) {
                if (Storage::disk('public')->exists($photo->photo)) {
                    Storage::disk('public')->delete($photo->photo);
                }
            }

            // حذف الصور من قاعدة البيانات
            $product->photos()->delete();

            // حذف المنتج نفسه
            return $product->delete();
        } catch (\Exception $e) {
            throw new \Exception('Error deleting product: ' . $e->getMessage());
        }
    }
     public function getAll()
    {
        return Product::with('category', 'color', 'fabric', 'wood');
    }


}

