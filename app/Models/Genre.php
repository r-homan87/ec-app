<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // productsとのリレーション
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
