<?php

use App\Models\Product;
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
        Schema::create('wishing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignIdFor(Product::class,'haysell_id')->references('haysell_id')->on('products')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishing_lists');
    }
};
