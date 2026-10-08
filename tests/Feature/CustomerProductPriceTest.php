<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerProductPrice;

class CustomerProductPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_have_a_specific_product_price():void{
        $user = User::factory()->create();
        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'wholesale',
            'name' => 'Wholesale Customer',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $category = Category::create([
            'name' => 'Air Fryer',
            'slug' => 'air fryer',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Gosonic Air Fryer 869',
            'slug' => 'gosonic-air-fryer-869',
            'sku' => 'GOS-869',
            'purchase_price' => 1200000000,
            'sale_price' => 14000000,
        ]); 

        $specificPrice = CustomerProductPrice::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'price' => 13700000,
        ]);

        $this->assertTrue(
            $customer->productprices->contains($specificPrice)
        );
    }

    public function test_product_can_have_customer_specific_prices():void{
        $user = User::factory()->create();
        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'wholesale',
            'name' => 'Wholesale Customer',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $category = Category::create([
            'name' => 'Air Fryer',
            'slug' => 'air fryer',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Gosonic Air Fryer 869',
            'slug' => 'gosonic-air-fryer-869',
            'sku' => 'GOS-869',
            'purchase_price' => 1200000000,
            'sale_price' => 14000000,
        ]); 

        $specificPrice = CustomerProductPrice::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'price' => 13700000,
        ]);

        $this->assertTrue(
            $product->customerprices->contains($specificPrice)
        );
    }

        public function test_customer_cannot_have_duplicate_price_for_same_product():void{
        $user = User::factory()->create();
        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'wholesale',
            'name' => 'Wholesale Customer',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $category = Category::create([
            'name' => 'Air Fryer',
            'slug' => 'air fryer',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Gosonic Air Fryer 869',
            'slug' => 'gosonic-air-fryer-869',
            'sku' => 'GOS-869',
            'purchase_price' => 1200000000,
            'sale_price' => 15000000,
        ]); 

        CustomerProductPrice::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'price' => 13700000,
        ]);


        $this->expectException(QueryException::class);
        CustomerProductPrice::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'price' => 13500000,
        ]);

    }

}
