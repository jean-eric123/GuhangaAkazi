<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();

            $table->string('organization')->nullable();
            $table->string('location')->nullable();
            $table->string('external_url')->nullable();

            $table->date('opens_at')->nullable();
            $table->date('closes_at')->nullable();

            $table->enum('status', ['upcoming', 'open', 'closed', 'expired'])->default('open');

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
            $table->index('status');
            $table->index('closes_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
