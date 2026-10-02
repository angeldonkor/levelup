<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();

            // Coach die de challenge heeft aangemaakt
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('unit');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('rules');
            $table->decimal('min_value', 10, 2);
            $table->decimal('max_value', 10, 2);

            // Bepaalt of de ranglijst zichtbaar is voor sportleden
            $table->boolean('leaderboard_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};