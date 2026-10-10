<?php

namespace App\Services;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function calculateItemTotal(float $unitPrice, int $quantity): float {
        
        if ($unitPrice < 0) {
            throw new \InvalidArgumentException(
                'Unit price cannot be negative.'
            );
        }

        if ($quantity < 0) {
            throw new \InvalidArgumentException(
                'Quantity cannot be negative.'
            );
        }

        return $unitPrice * $quantity;
    }



}
