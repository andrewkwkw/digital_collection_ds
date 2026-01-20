<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            // Drop identifier and language columns
            $table->dropColumn(['identifier', 'language']);
            
            // Rename coverage to reach
            $table->renameColumn('coverage', 'reach');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            // Add back the dropped columns
            $table->string('identifier')->nullable();
            $table->string('language')->nullable();
            
            // Rename reach back to coverage
            $table->renameColumn('reach', 'coverage');
        });
    }
};
