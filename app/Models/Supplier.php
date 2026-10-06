<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;


class Supplier extends Model
{
    protected $fillable =[
        'user_id',
        'name',
        'company_name',
        'phone',
        'email',
        'address',
        'description',
        'is_active',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('purchase_price','stock')->withTimestamps();
    }
}
