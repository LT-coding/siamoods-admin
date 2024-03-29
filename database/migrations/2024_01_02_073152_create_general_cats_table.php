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
        Schema::create('general_cats', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('show_in_item');
            $table->boolean('show_in_web');
            $table->boolean('is_main');
            $table->boolean('is_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_cats');
    }
};
