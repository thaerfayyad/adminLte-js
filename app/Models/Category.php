<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function getVisibilityAttribute()
    {
        return $this->status ? 'Visible' :'Hidden' ;
    }
     public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function products()
    {
    return $this->hasManyThrough(Product::class,Subcategory::class,'category_id','subcategory_id','id','id');

    }
}
