<?php

use App\Models\ProductVariation;
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
        Schema::create('product_variation_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductVariation::class,'variation_haysell_id')->references('variation_haysell_id')->on('product_variations')->cascadeOnDelete();
            $table->string('type');
            $table->float('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_prices');
    }
};
