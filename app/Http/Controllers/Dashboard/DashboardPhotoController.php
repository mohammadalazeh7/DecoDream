<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardStoreProductRequest;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardPhotoController extends Controller
{
    //
//     public function store(DashboardStoreProductRequest $request)
// {
//     $validatedData = $request->validated();

    //     // إنشاء المنتج الأساسي
//     $product = Product::create($validatedData);

    //     // حفظ الصور
//     if ($request->hasFile('images')) {
//         foreach ($request->file('images') as $image) {
//             $path = $image->store('products/' . $product->id, 'public');
//             $product->photos()->create(['photo' => $path]);
//         }
//     }

    //     return redirect()->route('products.index')
//         ->with('success', 'تم إنشاء المنتج بنجاح.');
// }
    public function destroyPhoto(Photo $photo)
    {
        // dd(vars: $photo);

        // حذف الصورة من التخزين
        Storage::disk('public')->delete($photo->id);

        // حذف السجل من قاعدة البيانات
        $photo->delete();
         
        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح.');
    }

}
