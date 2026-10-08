<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Customer;
use App\MOdels\SalesChannel;


class ProductPriceHistory extends Model
{
    protected $fillable = [
        'product_id',
        'price_type',
        'old_price',
        'price',
        'customer_id',
        'sales_channel_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function salesChannel(){
        return $this->belongsTo(SalesChannel::class);
    }
}
