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
        Schema::create('power_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type');
            $table->integer('status');
            $table->text('description')->nullable();
            $table->text('media')->nullable();
            $table->string('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_labels');
    }
};
