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
        Schema::create('product_price_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')
                    ->constrained('products')
                    ->cascadeOnDelete();

                $table->enum('price_type', [
                    'retail',
                    'wholesale',
                    'customer_specific',
                    'channel',
                ]);

                $table->decimal('old_price', 15, 2)->nullable();
                $table->decimal('price', 15, 2);

                $table->foreignId('customer_id')
                    ->nullable()
                    ->constrained('customers')
                    ->nullOnDelete();

                $table->foreignId('sales_channel_id')
                    ->nullable()
                    ->constrained('sales_channels')
                    ->nullOnDelete();

                $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_histories');
    }
};
