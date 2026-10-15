<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();

            $table->decimal('capital_min', 15, 2)->nullable();
            $table->decimal('capital_max', 15, 2)->nullable();
            $table->decimal('operating_costs', 15, 2)->nullable();
            $table->decimal('expected_revenue', 15, 2)->nullable();
            $table->decimal('expected_profit', 15, 2)->nullable();
            $table->string('currency', 10)->default('RWF');

            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->nullable();
            $table->string('time_to_start')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->unsignedBigInteger('comments_count')->default(0);

            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'is_featured']);
            $table->index('published_at');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
