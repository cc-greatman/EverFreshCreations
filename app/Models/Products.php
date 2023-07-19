<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'quantity',
        'price',
        'category',
        'discount_price',
    ];

    public function product_images() {

        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function category() {

        return $this->belongsTo(Category::class);
    }

    public function cart () {

        return $this->belongsTo(Cart::class);
    }
}
