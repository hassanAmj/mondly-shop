<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;


class CustomerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_belongs_to_user():void{
        $user = User::factory()->create();
        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'retail',
            'name' => 'Test Customer',
        ]);

        $this->assertTrue(
            $customer->user->is($user)
        );
    }

    public function test_user_has_one_customer(){
        $user = User::factory()->create();
        $customer = Customer::create([
            'user_id' => $user->id,
            'type' => 'wholesale',
            'name' => 'wholesale',
        ]);

        $this->assertTrue(
            $user->customer->is($customer)
        );
    }

}
