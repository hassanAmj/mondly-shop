<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\CustomerProductPrice;
use App\Models\ProductPriceHistory;
use App\Models\Order;

class Customer extends Model
{
    protected $fillable =[
        'user_id',
        'type',
        'name',
        'phone',
        'email',
        'is_active',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productprices(){
        return $this->hasMany(CustomerProductPrice::class);
    }

        public function priceHistories(){
        return $this->hasMany(ProductPriceHistory::class);
    }

    public function orders(){
       return $this->hasMany(Order::class);
    }
}
