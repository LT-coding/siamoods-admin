<?php

use App\Enums\ContentTypes;
use App\Enums\StatusTypes;
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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ContentTypes::getKeys())->default(ContentTypes::page->name);
            $table->string('title');
            $table->text('image')->nullable();
            $table->longText('description');
            $table->boolean('status')->default(StatusTypes::active->value);
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
