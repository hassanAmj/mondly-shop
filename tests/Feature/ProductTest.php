<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_product_belongs_to_brand_and_category():void{
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

            $this->assertTrue($product->brand->is($brand));
            $this->assertTrue($product->category->is($category));

    }


    public function test_brand_and_category_can_have_products():void{
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

        $this->assertTrue(
            $brand->products->contains($product)
        );

        $this->assertTrue(
            $category->products->contains($product)
        );


    }
}
