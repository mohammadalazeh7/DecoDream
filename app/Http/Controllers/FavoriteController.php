<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $product = Product::findOrFail($validated['product_id']);
        $result = $this->favoriteService->toggleFavorite($product);
        if ($result === 'added') {
            return ApiResponse::success('Added to favorites');
        } else {
            return ApiResponse::success('Removed from favorites');
        }
    }

    public function index()
    {
        $favorites = $this->favoriteService->getUserFavorites();

        return ProductResource::collection($favorites);
    }

}
