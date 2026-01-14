<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Photo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->clearExistingImages();

        // Create storage directory if it doesn't exist
        $storagePath = storage_path('app/public/products');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Get all products
        $products = Product::all();

        // Define image mappings for each product
        $productImages = [
            1 => ['1_Modern_Sofa.jpeg'],
            2 => ['2_Classic_Chair.jpg'],
            3 => ['3_Wooden_Table.jpeg'],
            4 => ['4_Luxury_Bed.jpeg'],
            5 => ['5_Office_Desk.jpeg'],
            6 => ['6_Bookshelf.jpeg'],
            7 => ['7_Dining_Table.jpeg'],
            8 => ['8_Recliner.jpg'],
            9 => ['9_TV_Stand.jpg'],
            10 => ['10_Wardrobe.jpg']
        ];

        // Loop through each product
        foreach ($products as $product) {
            // Get images for this product
            $imageFiles = $productImages[$product->id] ?? [];
            
            foreach ($imageFiles as $imageFileName) {
                $sourcePath = public_path('sample-images/' . $imageFileName);
                
                if (File::exists($sourcePath)) {
                    // Copy to storage
                    $destinationPath = 'products/' . $imageFileName;
                    
                    if (!Storage::disk('public')->exists($destinationPath)) {
                        Storage::disk('public')->put($destinationPath, File::get($sourcePath));
                    }

                    // Create DB record (avoid duplicate DB records)
                    if (!Photo::where('product_id', $product->id)->where('photo', $destinationPath)->exists()) {
                        Photo::create([
                            'product_id' => $product->id,
                            'photo' => $destinationPath,
                        ]);
                    }
                } else {
                    $this->command->warn("Image file not found: {$imageFileName} for product ID: {$product->id}");
                }
            }
        }

        $this->command->info('Product photos seeded successfully!');
    }

    private function clearExistingImages(): void
    {
        $storagePath = storage_path('app/public/products');
        if (File::exists($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        Photo::truncate();
    }
}
