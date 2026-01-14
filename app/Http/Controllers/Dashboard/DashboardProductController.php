<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardStoreProductRequest;
use App\Http\Requests\DashboardUpdateProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Wood;
use App\Services\DashboardProductServies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardProductController extends Controller
{
    //

    protected $productService;

    public function __construct(DashboardProductServies $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $query = $this->productService->getAll();


        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        if ($request->filled('product_name')) {
            $query->where('name', 'like', '%' . $request->product_name . '%');
        }

        if ($request->filled('category_name')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category_name . '%');
            });
        }

        if ($request->filled('product_id')) {
            return redirect()->route('products.index')
                ->with('error', 'No results found according to your search');
        }
        if ($request->filled('product_name')) {
            return redirect()->route('products.index')
                ->with('error', 'No results found according to your search');
        }
        if ($request->filled('category_name')) {
            return redirect()->route('products.index')
                ->with('error', 'No results found according to your search');
        }

        $products = $query->paginate(10)
            ->appends($request->except('page'));

        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $fabrics = Fabric::all();
        $woods = Wood::all();
        return view('admin.products.create', compact('categories', 'colors', 'fabrics', 'woods'));
    }

    public function store(DashboardStoreProductRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // إضافة الصور للبيانات المصححة
            if ($request->hasFile('images')) {
                $validatedData['images'] = $request->file('images');
            }

            $this->productService->create($validatedData);

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the product: ' . $e->getMessage());
        }
    }

    // public function store(DashboardStoreProductRequest $request)
    // {
    //     $this->productService->create($request->validated());

    //     return redirect()->route('products.index')
    //         ->with('success', 'Product created successfully');
    // }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $colors = Color::all();
        $fabrics = Fabric::all();
        $woods = Wood::all();
        //  dd($categories, $colors, $fabrics, $woods);
        return view('admin.products.edit', compact('product', 'categories', 'colors', 'fabrics', 'woods'));
    }

    public function update(DashboardUpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        try {
            // إضافة الصور الجديدة للبيانات المصححة
            if ($request->hasFile('images')) {
                $validatedData['images'] = $request->file('images');
            }

            // إضافة الصور المحددة للحذف
            if ($request->filled('photos_to_delete')) {
                $validatedData['photos_to_delete'] = $request->photos_to_delete;
            }

            $this->productService->update($product, $validatedData);

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
        }
    }

    // public function update(DashboardUpdateProductRequest $request, Product $product)
    // {
    //     $this->productService->update($product, $request->validated());

    //     return redirect()->route('products.index')
    //         ->with('success', 'تم تعديل المنتج بنجاح.');

    // }

    public function destroy(Product $product)
    {
        try {
            $this->productService->delete($product);

            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the product: ' . $e->getMessage());
        }
    }
    // public function destroy(Product $product)
    // {
    //     $this->productService->delete($product);

    //     return redirect()->route('products.index')
    //         ->with('success', 'Product deleted successfully.');
    // }
    // public function destroyPhoto(Photo $photo)
    // {

    //     // حذف الصورة من التخزين
    //     $t = Storage::disk('public')->delete($photo->id);
    //     dd($t);
    //     // حذف السجل من قاعدة البيانات
    //     $photo->delete();

    //     return redirect()->back()->with('success', 'تم حذف الصورة بنجاح.');
    // }

}
