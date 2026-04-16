<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_respostas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('match_user_id')->constrained('match_users')->cascadeOnDelete();
            $table->foreignId('pergunta_id')->constrained('perguntas')->cascadeOnDelete();
            $table->char('alternativa', 1);
            $table->timestamps();

            $table->unique(['match_user_id', 'pergunta_id']);
            $table->index('match_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_respostas');
    }
};
