<?php

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
        Schema::create('account_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('type',['shipping','payment']);
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('country')->default('AM')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('same_for_payment')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_addresses');
    }
};
