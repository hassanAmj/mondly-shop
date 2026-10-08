<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_channel_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_channel_id')->constrained('sales_channels')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('customer_type',[
                'retail',
                'wholesale',
            ]);
            $table->decimal('price', 15,2);
            $table->timestamps();
            $table->unique([
                'sales_channel_id',
                'product_id',
                'customer_type',
            ],
                'sales_channel_product_prices_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_channel_product_prices');
    }
};
