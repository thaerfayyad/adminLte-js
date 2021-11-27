<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory , Notifiable;
    protected  $fillable = ['*'];

    public function getVisibilityAttribute()
    {
        return $this->status ? 'Visible' :'Hidden' ;
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);

    }

}
