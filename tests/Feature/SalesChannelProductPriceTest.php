<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerProductPrice;
use App\Models\SalesChannel;
use App\Models\SalesChannelProductPrice;


class SalesChannelProductPriceTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_product_can_have_sales_channel_prices():void{

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
            'retail_price' => 14000000,
            'stock' => 10,
            'is_active' => true,
        ]); 

        $saleschannel = SalesChannel::create([
            'name' => 'Website',
            'slug' => 'website',
            'is_active' => true,
        ]);

        $price = SalesChannelProductPrice::create([
            'sales_channel_id' => $saleschannel->id,
            'product_id' => $product->id,
            'customer_type' => 'retail',
            'price' => 15500000,
        ]);

        $this->assertTrue(
            $product->salesChannelPrices->contains($price)
        );
    }

    public function test_sales_channel_can_have_product_prices():void{

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
            'retail_price' => 14000000,
            'stock' => 10,
            'is_active' => true,
        ]); 

        $saleschannel = SalesChannel::create([
            'name' => 'Website',
            'slug' => 'website',
            'is_active' => true,
        ]);

        $price = SalesChannelProductPrice::create([
            'sales_channel_id' => $saleschannel->id,
            'product_id' => $product->id,
            'customer_type' => 'retail',
            'price' => 15500000,
        ]);

        $this->assertTrue(
            $saleschannel->productPrices->contains($price)
        );

    }

    public function test_price_can_belong_to_product_and_sales_channel():void{
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
            'retail_price' => 14000000,
            'stock' => 10,
            'is_active' => true,
        ]); 

        $saleschannel = SalesChannel::create([
            'name' => 'Website',
            'slug' => 'website',
            'is_active' => true,
        ]);

        $price = SalesChannelProductPrice::create([
            'sales_channel_id' => $saleschannel->id,
            'product_id' => $product->id,
            'customer_type' => 'retail',
            'price' => 15500000,
        ]);
        
        $this->assertTrue(
            $price->product->is($product)
        );

        $this->assertTrue(
            $price->salesChannel->is($saleschannel)
        );
    }

}
