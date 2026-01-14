<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardCategoryRequest;
use App\Models\Category;
use App\Services\DashboardCategoryService;
use Illuminate\Http\Request;

class DashboardCategoryController extends Controller
{
    //
    protected $categoryService;

    public function __construct(DashboardCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        // $categories = $this->categoryService->getAll();
        $query = $this->categoryService->getAll();

        if ($request->filled('category_name')) {
            $query->where('name', 'like', '%' . $request->category_name . '%');
        }



        if ($request->filled('category_name')) {
            return redirect()->route('categories.index')
                ->with('error', 'No results found according to your search');
        }

          $categories = $query->paginate(10)
            ->appends($request->except('page'));

        return view('admin.categories.index', compact('categories'));

    }
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(DashboardCategoryRequest $request)
    {
        $this->categoryService->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(DashboardCategoryRequest $request, Category $category)
    {
        $this->categoryService->update($request->validated(), $category);
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $deleted = $this->categoryService->delete($category);

        // if (!$deleted) {
        //     return redirect()->route('categories.index')
        //         ->with('error', 'Cannot delete category. There are products associated with this category.');
        // }

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function delete(Category $category)
    {
        return view('admin.categories.delete', compact('category'));
    }
}
