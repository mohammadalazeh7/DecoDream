<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wood extends Model
{
    use SoftDeletes;
    protected $table = 'woods';
    protected $fillable = ['wood_type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
