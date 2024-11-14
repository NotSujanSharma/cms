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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->text('description');
            $table->string('picture_path')->nullable();
            $table->datetime('date');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Add indexes for common queries
            $table->index('date');
            $table->index('headline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
