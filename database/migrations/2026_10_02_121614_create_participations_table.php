<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('challenge_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('joined_at')->useCurrent();

            $table->timestamps();

            // Een sportlid kan maar één keer deelnemen aan dezelfde challenge
            $table->unique(['user_id', 'challenge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};