<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductPriceHistory;
use App\Models\SalesChannel;

class ProductPriceHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_have_price_histories():void{
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
            'stock' => 10,
            'is_active' => true,
        ]); 

        $history = ProductPriceHistory::create([
            'product_id' => $product->id,
            'price_type' => 'retail',
            'old_price' =>14000000,
            'price' => 15000000,
        ]);

        $this->assertTrue(
            $product->priceHistories->contains($history)
        );
    }

    public function test_customer_can_have_price_histories():void{
        $user = User::create([
            'name' => 'Test User',
            'email' => 'customer-history@example.com',
            'password' => bcrypt('password'),
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'wholesale',
            'name' => 'Test Customer',
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
            'stock' => 10,
            'is_active' => true,
        ]); 

        $history = ProductPriceHistory::create([
            'product_id' => $product->id,
            'price_type' => 'customer_specific',
            'old_price' =>14000000,
            'price' => 14500000,
            'customer_id' => $customer->id,
        ]);

        $this->assertTrue(
            $customer->priceHistories->contains($history)
        );
    }

    public function test_sales_channel_can_have_price_histories():void{
        $saleschannel = SalesChannel::create([
            'name' => 'Test Website',
            'slug' => 'test-website',
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'Test Brand',
            'slug' => 'test-brand-channel',
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category-channel',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Test Product Channel',
            'slug' => 'trst-product-channel',
            'sku' => 'TEST-CHANNEL-001',
            'purchase_price' => 1000000000,
            'sale_price' => 15000000,
            'stock' => 10,
        ]); 

        $history = ProductPriceHistory::create([
            'product_id' => $product->id,
            'price_type' => 'channel',
            'old_price' =>15000000,
            'price' => 15500000,
            'sales_channel_id' => $saleschannel->id,
        ]);

        $this->assertTrue(
            $saleschannel->priceHistories->contains($history)
        );
    }
}

    

