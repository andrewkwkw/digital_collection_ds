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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('creator')->nullable();
            $table->text('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->string('contributor')->nullable();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->string('identifier')->nullable();
            $table->string('source')->nullable();
            $table->string('language')->nullable();
            $table->string('relation')->nullable();
            $table->string('coverage')->nullable();
            $table->string('rights')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
