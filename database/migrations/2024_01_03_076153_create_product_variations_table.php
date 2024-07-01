<?php

use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationType;
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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->foreignIdFor(Variation::class,'variation_id')->references('id')->on('variations')->cascadeOnDelete();
            $table->unsignedBigInteger('variation_haysell_id')->index()->nullable();
            $table->text('image')->nullable();
            $table->integer('balance');
            $table->boolean('status');
            $table->timestamp('again_available')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
