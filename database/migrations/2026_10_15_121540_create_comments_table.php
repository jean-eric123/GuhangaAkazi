<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('author_name');
            $table->string('author_email')->nullable();
            $table->text('body');
            $table->string('visitor_token', 64)->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_spam')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->references('id')->on('comments')->nullOnDelete();
            $table->index(['commentable_type', 'commentable_id', 'is_approved'], 'cmt_commentable_approved');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
