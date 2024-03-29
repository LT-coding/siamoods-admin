<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_haysell_id')->nullable();
            $table->integer('paid')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->integer('total')->default(0);
            $table->integer('promo_gift_count')->default(0);
            $table->integer('status')->default(0);
            $table->text('comment')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('staff_notes')->nullable();
            $table->integer('type')->default(1);
            $table->boolean('not_completed_two_days')->default(0);
            $table->boolean('not_completed_one_week')->default(0);
            $table->boolean('rate')->default(0);
            $table->boolean('order_canceled')->default(0);
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->unsignedBigInteger('shipping_type_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->unsignedBigInteger('gift_card_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->cascadeOnDelete();

            $table->foreign('gift_card_id')
                ->references('id')
                ->on('gift_cards')
                ->cascadeOnDelete();

            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
