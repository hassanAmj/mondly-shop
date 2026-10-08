<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesChannelProductPrice;

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
}
