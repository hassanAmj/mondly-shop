<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use App\Models\Brand;
use App\Models\Category;
use App\MOdels\ProductImage;
use App\Models\Supplier;
use App\Models\ProductBarcode;
use App\Models\CustomerProductPrice;
use App\Models\SalesChannelProductPrice;
use App\Models\ProductPriceHistory;

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

    public function productbarcods(){
        return $this->hasMany(ProductBarcode::class);
    }

    public function customerprices(){
        return $this->hasMany(CustomerProductPrice::class);
    }

    public function salesChannelPrices(){
        return $this->hasMany(SalesChannelProductPrice::class);
    }

    public function priceHistories(){
        return $this->hasMany(ProductPriceHistory::class);
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
