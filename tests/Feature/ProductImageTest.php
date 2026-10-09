<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;



class ProductImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_have_images():void
    {
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
            'purchase_price' => '12000000',
            'retail_price' => '14000000',
            'stock' => 10,
            'is_active' => true,
        ]);

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'product/gosonic/-869-jpg',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $this->assertTrue(
            $product->images->contains($image)
        );
    }

    public function test_image_belongs_to_product():void{

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
            'purchase_price' => '12000000',
            'retail_price' => '14000000',
            'stock' => 10,
            'is_active' => true,
        ]);

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'product/gosonic/-869-jpg',
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    
        $this->assertTrue(
            $image->product->is($product)
        );
    }

}
