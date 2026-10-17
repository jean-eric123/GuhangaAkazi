<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table("ideas", function (Blueprint $table) {
            // Widen to 20,2 (up to 999,999,999,999,999,999.99)
            $table->decimal("capital", 20, 2)->nullable()->change();
            $table->decimal("expected_profit", 20, 2)->nullable()->change();
            $table->decimal("operating_costs", 20, 2)->nullable()->change();
            $table->decimal("expected_revenue", 20, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table("ideas", function (Blueprint $table) {
            $table->decimal("capital", 15, 2)->nullable()->change();
            $table->decimal("expected_profit", 15, 2)->nullable()->change();
            $table->decimal("operating_costs", 15, 2)->nullable()->change();
            $table->decimal("expected_revenue", 15, 2)->nullable()->change();
        });
    }
};