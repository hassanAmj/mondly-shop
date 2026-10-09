<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_have_multiple_items(): void
    {
        $customer = Customer::create([
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $category = Category::create([
            'name' => 'Kitchen Appliances',
            'slug' => 'kitchen-appliances',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $product1 = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
            'sku' => 'AF-001',
            'purchase_price' => 10000000,
            'retail_price' => 14000000,
            'stock' => 10,
        ]);

        $product2 = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Chopper',
            'slug' => 'chopper',
            'sku' => 'CH-001',
            'purchase_price' => 2000000,
            'retail_price' => 2700000,
            'stock' => 5,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-001',
            'customer_id' => $customer->id,
            'source' => 'website',
            'status' => 'pending',
            'subtotal' => 16700000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 16700000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => 14000000,
            'subtotal' => 14000000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => 2700000,
            'subtotal' => 2700000,
        ]);

        $this->assertCount(2, $order->items);
    }

    public function test_order_belongs_to_customer():void
    {
        $customer = Customer::create([
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-002',
            'customer_id' => $customer->id,
            'source' => 'website',
            'status' => 'pending',
            'subtotal' => 1000000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 1000000,
        ]);

        $this->assertTrue($order->customer->is($customer));
        
    }

    public function test_order_item_belongs_to_product(): void
    {
        $category = Category::create([
            'name' => 'Kitchen Appliances',
            'slug' => 'kitchen-appliances',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
            'sku' => 'AF-TEST-003',
            'purchase_price' => 10000000,
            'retail_price' => 14000000,
            'stock' => 10,
        ]);

        $customer = Customer::create([
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-003',
            'customer_id' => $customer->id,
            'source' => 'website',
            'status' => 'pending',
            'subtotal' => 14000000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 14000000,
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 14000000,
            'subtotal' => 14000000,
        ]);

        $this->assertTrue($orderItem->product->is($product));
    }

    public function test_product_can_have_multiple_order_items(): void
    {
            $category = Category::create([
                'name' => 'Kitchen Appliances',
                'slug' => 'kitchen-appliances',
            ]);

            $brand = Brand::create([
                'name' => 'Gosonic',
                'slug' => 'gosonic',
            ]);

            $product = Product::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => 'Air Fryer',
                'slug' => 'air-fryer',
                'sku' => 'AF-TEST-004',
                'purchase_price' => 10000000,
                'retail_price' => 14000000,
                'stock' => 10,
            ]);

            $customer = Customer::create([
                'type' => 'retail',
                'name' => 'Test Customer',
            ]);

            $order1 = Order::create([
                'order_number' => 'ORD-TEST-004',
                'customer_id' => $customer->id,
                'source' => 'website',
                'status' => 'pending',
                'subtotal' => 14000000,
                'discount' => 0,
                'shipping_cost' => 0,
                'total' => 14000000,
            ]);

            $order2 = Order::create([
                'order_number' => 'ORD-TEST-005',
                'customer_id' => $customer->id,
                'source' => 'website',
                'status' => 'pending',
                'subtotal' => 28000000,
                'discount' => 0,
                'shipping_cost' => 0,
                'total' => 28000000,
            ]);

            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => 14000000,
                'subtotal' => 14000000,
            ]);

            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $product->id,
                'quantity' => 2,
                'unit_price' => 14000000,
                'subtotal' => 28000000,
            ]);

            $this->assertCount(2, $product->orderItems);   
    }

    public function test_order_item_keeps_price_at_purchase_time(): void
    {
        $category = Category::create([
            'name' => 'Kitchen Appliances',
            'slug' => 'kitchen-appliances',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
            'sku' => 'AF-TEST-005',
            'purchase_price' => 10000000,
            'retail_price' => 14000000,
            'stock' => 10,
        ]);

        $customer = Customer::create([
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-006',
            'customer_id' => $customer->id,
            'source' => 'website',
            'status' => 'pending',
            'subtotal' => 14000000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 14000000,
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 14000000,
            'subtotal' => 14000000,
        ]);

        $product->update([
            'retail_price' => 15000000,
        ]);

        $this->assertEquals(
            14000000,
            (float) $orderItem->fresh()->unit_price
        );

        $this->assertEquals(
            15000000,
            (float) $product->fresh()->retail_price
        );
    }

    public function test_order_item_subtotal_matches_quantity_times_unit_price(): void
    {
        $customer = Customer::create([
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $category = Category::create([
            'name' => 'Kitchen Appliances',
            'slug' => 'kitchen-appliances',
        ]);

        $brand = Brand::create([
            'name' => 'Gosonic',
            'slug' => 'gosonic',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Air Fryer',
            'slug' => 'air-fryer',
            'sku' => 'AF-TEST-006',
            'purchase_price' => 10000000,
            'retail_price' => 14000000,
            'stock' => 10,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-007',
            'customer_id' => $customer->id,
            'source' => 'website',
            'status' => 'pending',
            'subtotal' => 28000000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 28000000,
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 14000000,
            'subtotal' => 28000000,
        ]);

        $this->assertEquals(
            $orderItem->quantity * $orderItem->unit_price,
            (float) $orderItem->subtotal
        );
    }

    public function test_order_item_calculates_subtotal(): void
    {
        $orderItem = new OrderItem([
            'quantity' => 2,
            'unit_price' => 14000000,
        ]);

        $this->assertEquals(
            '28000000',
            $orderItem->calculateSubtotal()
        );
    }

}
