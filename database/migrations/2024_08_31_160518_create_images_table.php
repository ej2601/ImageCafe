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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('prompt');
            $table->string('image_path');
            $table->integer('width');
            $table->integer('height');
            $table->decimal('aspect_ratio', 5, 2);
            $table->unsignedBigInteger('seed')->nullable();
            $table->json('category_ids')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('can_download')->default(false);
            $table->boolean('hide_prompt')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
