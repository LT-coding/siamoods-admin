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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('haysell_id')->index()->nullable();
            $table->string('articul')->nullable();
            $table->string('item_name');
            $table->string('item_type')->nullable();;
            $table->integer('type')->default(0);
            $table->string('sort')->nullable();
            $table->string('provider')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('balance_control')->nullable();
            $table->string('additional')->nullable();
            $table->float('discount')->default(0);
            $table->date('discount_end_date')->nullable();
            $table->integer('discount_type')->nullable();
            $table->text('description')->nullable();
            $table->text('item_type_num')->nullable();
            $table->boolean('liked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
