<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'discription'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function brands(){
        return $this->hasMany(Brand::class,'category_id','id');
    }
}
