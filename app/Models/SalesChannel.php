<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesChannelProductPrice;
use App\Models\ProductPriceHistory;

class SalesChannel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function productPrices(){
        return $this->hasMany(SalesChannelProductPrice::class);
    }

    public function priceHistories(){
        return $this->hasMany(ProductPriceHistory::class);
    }

}
