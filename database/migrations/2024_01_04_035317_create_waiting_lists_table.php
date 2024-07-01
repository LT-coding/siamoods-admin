<?php

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
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
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class,'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->foreignIdFor(ProductVariation::class,'variation_haysell_id')->references('variation_haysell_id')->on('product_variations')->cascadeOnDelete();
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
