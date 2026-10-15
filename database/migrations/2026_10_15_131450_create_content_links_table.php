<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_links', function (Blueprint $table) {
            $table->id();
            $table->morphs('source');   // source_type, source_id
            $table->morphs('target');   // target_type, target_id
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Prevent duplicate links in the same direction
            $table->unique(
                ['source_type', 'source_id', 'target_type', 'target_id'],
                'unique_source_target'
            );

            // Fast lookup for "what links to this content"
            $table->index(['target_type', 'target_id'], 'idx_target');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_links');
    }
};
