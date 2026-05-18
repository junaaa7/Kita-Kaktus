<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'stock', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    
    public function ratingCount()
    {
        return $this->ratings()->count();
    }
}