<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            // Additive only — capital_min / capital_max remain but are unused in the app.
            $table->decimal('capital', 15, 2)->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn('capital');
        });
    }
};
