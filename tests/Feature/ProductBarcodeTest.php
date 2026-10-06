<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\Brand;
use App\Models\Category;


class ProductBarcodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_have_barcodes():void{
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

        $barcode = ProductBarcode::create([
            'product_id' => $product->id,
            'barcode' => '6261234567890',
            'is_primary' => true,
        ]);

        $this->assertTrue(
            $product->productbarcods->contains($barcode)
        );

    }

    public function test_barcode_belongs_to_product():void{
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

        $barcode = ProductBarcode::create([
            'product_id' => $product->id,
            'barcode' => '6261234567890',
            'is_primary' => true,
        ]);

        $this->assertTrue(
            $barcode->product->is($product)
        );
    }
}
