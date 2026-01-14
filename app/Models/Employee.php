<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $table = "employees";
    protected $fillable = ["name", "email", "password","role_id"];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
      public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function invoice(){

          return $this->hasMany(Invoice::class);
          
    }

}
