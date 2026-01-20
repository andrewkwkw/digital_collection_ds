<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('archive_files', function (Blueprint $table) {
            $table->string('original_filename')->nullable()->after('archive_path');
        });
    }

    public function down(): void
    {
        Schema::table('archive_files', function (Blueprint $table) {
            $table->dropColumn('original_filename');
        });
    }
};
