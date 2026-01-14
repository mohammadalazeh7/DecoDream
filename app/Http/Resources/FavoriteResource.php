<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'description' => $this->product->description,
                'available_quantity' => $this->product->available_quantity,
                'category' => $this->product->category->name,
                'color' => $this->product->color->name,
                'fabric' => $this->product->fabric->fabric_type,
                'wood' => $this->product->wood->wood_type,
                'images' => $this->product->photos->map(fn($image) => $image->photo),
                
            ],
        ];
    }
}