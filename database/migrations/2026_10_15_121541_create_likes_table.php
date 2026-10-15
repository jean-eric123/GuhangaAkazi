<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->morphs('likeable');
            $table->string('visitor_token', 64);
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();
            $table->unique(['likeable_type', 'likeable_id', 'visitor_token'], 'unique_like');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
