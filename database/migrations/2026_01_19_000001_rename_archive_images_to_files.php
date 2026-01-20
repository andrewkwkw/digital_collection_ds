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
        // Rename archive_images table to archive_files
        Schema::rename('archive_images', 'archive_files');
        
        // Rename image_path column to archive_path
        Schema::table('archive_files', function (Blueprint $table) {
            $table->renameColumn('image_path', 'archive_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename archive_files table back to archive_images
        Schema::rename('archive_files', 'archive_images');
        
        // Rename archive_path column back to image_path
        Schema::table('archive_images', function (Blueprint $table) {
            $table->renameColumn('archive_path', 'image_path');
        });
    }
};
