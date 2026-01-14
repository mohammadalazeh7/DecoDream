<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
     use SoftDeletes;
    protected $table = 'fabrics';
    protected $fillable = ['fabric_type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
