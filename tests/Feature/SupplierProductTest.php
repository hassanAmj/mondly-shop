<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class SupplierProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_have_suppliers():void{
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

        $user = \App\Models\User::factory()->create();

        $supplier = Supplier::create([
            'user_id' => $user->id,
            'name' => 'Supplier A',
            'company_name' => 'Company A',
            'phone' => '09120000000',
            'email' => 'supplier@gmail.com',
            'is_active' => true,
        ]);

        $product->suppliers()->attach($supplier->id,['purchase_price'=> 13000000,'stock'=> 20]);
        $this->assertTrue(
            $product->suppliers->contains($supplier)
        );

    }

    public function test_supplier_can_have_products():void{
        $user = \App\Models\User::factory()->create();
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'name' => 'Supplier A',
            'company_name' => 'Company A',
            'phone' => '09120000000',
            'email' => 'supplier@example.com',
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $category = Category::create([
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
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

        $supplier->products()->attach($product->id,[
            'purchase_price' => 13000000,
            'stock' => 20,
        ]);

        $this->assertTrue(
            $supplier->products->contains($product)
        );
    }

    public function test_supplier_product_pivot_data_is_correct():void{
        $user = \App\Models\User::factory()->create();
        $supplier = Supplier::create([
            'user_id' => $user->id,
            'name' => 'Supplier A',
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $category = Category::create([
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
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

        $product->suppliers()->attach($supplier->id, [
            'purchase_price' => 13000000,
            'stock' => 20,
        ]);

        $supplierProduct = $product->suppliers->first();

        $this->assertEquals(

            13000000,
            $supplierProduct->pivot->purchase_price
        );

        $this->assertEquals(
            20,
            $supplierProduct->pivot->stock
        );

    }
}
