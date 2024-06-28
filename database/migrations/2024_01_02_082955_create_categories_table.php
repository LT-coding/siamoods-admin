<?php

use App\Models\Category;
use App\Models\GeneralCategory;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class,'parent_id')->nullable();
            $table->foreignIdFor(GeneralCategory::class, 'general_category_id')->references('id')->on('general_cats')->cascadeOnDelete();
            $table->string('name');
            $table->tinyInteger('delete')->default(0);
            $table->string('level');
            $table->string('short_url');
            $table->string('status');
            $table->string('additional')->nullable();
            $table->string('extra_categories')->nullable();
            $table->bigInteger('sort')->default(0);;
            $table->boolean('recommended')->default(0);;
            $table->boolean('is_top')->default(0);
            $table->text('image')->nullable();
            $table->text('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
