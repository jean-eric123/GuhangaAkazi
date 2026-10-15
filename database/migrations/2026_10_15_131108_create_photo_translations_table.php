<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photo_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('alt_text')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();

            $table->timestamps();

            $table->unique(['photo_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_translations');
    }
};
