<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;
use App\Models\Category;
use App\MOdels\ProductImage;
use App\Models\Supplier;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'is_active',
    ];


    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function suppliers(){
        return $this->BelongsToMany(Supplier::class)->withPivot('purchase_price','stock')->withTimestamps();
    }
}
