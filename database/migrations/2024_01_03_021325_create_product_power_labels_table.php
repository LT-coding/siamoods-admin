<?php

use App\Models\PowerLabel;
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
        Schema::create('product_power_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->foreignIdFor(PowerLabel::class, 'label_id')->references('id')->on('power_labels')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_power_labels');
    }
};
