<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('video_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->cascadeOnDelete();
            $table->morphs('attachable');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['video_id', 'attachable_type', 'attachable_id'], 'unique_video_attach');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_attachments');
    }
};
