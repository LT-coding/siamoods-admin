<?php

use App\Models\Category;
use App\Models\GeneralCategory;
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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class,'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->foreignIdFor(Category::class,'category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->unsignedBigInteger('general_category_id')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
