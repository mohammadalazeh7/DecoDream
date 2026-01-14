<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Wood;
use App\Models\ProductImage;
use App\Models\Favorite;
use App\Models\User;
use App\Models\OrderItem;

class Product extends Model
{
    use SoftDeletes;
    protected $table = "products";
    protected $fillable = ["price", "name", "description", "available_quantity", "color_id", "category_id", "fabric_id", "wood_id"];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function wood()
    {
        return $this->belongsTo(Wood::class);
    }

    
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
