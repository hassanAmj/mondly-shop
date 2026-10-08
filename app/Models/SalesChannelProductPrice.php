<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesChannel;
use App\Models\Product;

class SalesChannelProductPrice extends Model
{
    protected $fillable = [
        'sales_channel_id',
        'product_id',
        'customer_type',
        'price',
    ];

    public function salesChannel(){
        return $this->belongsTo(SalesChannel::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
