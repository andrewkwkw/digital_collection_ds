<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable(); // e.g. Dosen Prodi Sastra Indoneisa
            $table->string('photo_path')->nullable(); // Storage path
            $table->string('education')->nullable(); // e.g. S2
            $table->string('nidn')->nullable();
            $table->string('nip')->nullable();
            // External IDs (Nullable)
            $table->string('sinta_id')->nullable();
            $table->string('scholar_id')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('orcid_id')->nullable();
            $table->string('publon_id')->nullable();

            $table->string('expertise')->nullable();
            $table->string('research_focus')->nullable();
            $table->string('cv_path')->nullable(); // Storage path for PDF CV
            $table->string('email')->nullable();
            $table->integer('order')->default(0); // For sorting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
