<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OrderService;

class OrderServiceTest extends TestCase
{
    public function test_it_calculates_item_total():void{
        $service = new OrderService();
        $total = $service->calculateItemTotal(200000,3);

        $this->assertsame(600000.0,$total);
    }

    public function test_it_calculates_zero_quantity(): void
    {
        $service = new OrderService();

        $total = $service->calculateItemTotal(200000, 0);

        $this->assertSame(0.0, $total);
    }

    public function test_it_rejects_negative_quantity(): void
    {
        $service = new OrderService();

        $this->expectException(\InvalidArgumentException::class);

        $service->calculateItemTotal(200000, -2);
    }

    public function test_it_rejects_negative_unit_price():void{
        $service = new OrderService();
        $this->expectException(\InvalidArgumentException::class);
        $service->calculateItemTotal(-200000,3);
    }

}
