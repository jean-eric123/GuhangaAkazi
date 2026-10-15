<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skill_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);

            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();

            $table->longText('materials')->nullable();
            $table->longText('instructions')->nullable();
            $table->longText('applications')->nullable();
            $table->longText('tips')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();

            $table->timestamps();

            $table->unique(['skill_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_translations');
    }
};
