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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ders_id')->constrained('derses')->cascadeOnDelete();
            $table->string('title');
            $table->string('audio_file');
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedInteger('start_page');
            $table->unsignedInteger('end_page')->nullable();
            $table->unsignedInteger('sort_order');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
