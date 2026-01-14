<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function toggleFavorite(Product $product): string
    {
        $user = Auth::user();

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            return 'removed';
        } else {
            $user->favorites()->attach($product->id);

            return 'added';
        }
    }

    public function isFavorited(Product $product): bool
    {
        $user = Auth::user();
        return $user->favorites()->where('product_id', $product->id)->exists();
    }
    public function getUserFavorites()
    {
        $user = Auth::user();

        // Eager-load the necessary relationships on the favorite products.
        return $user->favorites()->with(['photos', 'favorites'])->get();
    }

}

