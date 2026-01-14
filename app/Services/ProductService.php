<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ProductService
{
    private function getAuthenticatedUser(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken) {
                return $accessToken->tokenable;
            }
        }
        return null;
    }

    public function getAll(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        $perPage = $request->input('per_page', 10);
        $query = Product::query();

        if ($user) {
            Auth::setUser($user); // Set user for this request cycle
            $query->with(['photos', 'favorites']);
        } else {
            $query->with('photos');
        }

        return $query->paginate($perPage);
    }

    public function search(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        $name = $request->input('name');
        $perPage = $request->input('per_page', 15);
        $query = Product::query()->where('name', 'LIKE', '%' . $name . '%');

        if ($user) {
            Auth::setUser($user); // Set user for this request cycle
            $query->with(['photos', 'favorites']);
        } else {
            $query->with('photos');
        }

        return $query->paginate($perPage);
    }

    public function getByCategory(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        $categoryId = $request->input('category_id');
        $perPage = $request->input('per_page', 5);
        $query = Product::where('category_id', $categoryId);

        if ($user) {
            Auth::setUser($user); // Set user for this request cycle
            $query->with(['photos', 'favorites']);
        } else {
            $query->with('photos');
        }

        return $query->paginate($perPage);
    }

    public function getAllCategories()
    {
        return Category::all();
    }
}