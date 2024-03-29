<?php

use App\Models\Product;
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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreignIdFor(Product::class,'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('total')->default(0);
            $table->integer('sale')->default(0);
            $table->integer('discount_total')->nullable();
            $table->integer('gift')->default(0);
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
