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
        Schema::create('product_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->integer('balance');
            $table->timestamp('again_available')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_balances');
    }
};
