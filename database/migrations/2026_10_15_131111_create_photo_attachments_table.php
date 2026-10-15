<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photo_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            $table->morphs('attachable');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['photo_id', 'attachable_type', 'attachable_id'], 'unique_photo_attach');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_attachments');
    }
};
