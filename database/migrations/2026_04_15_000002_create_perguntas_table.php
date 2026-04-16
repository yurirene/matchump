<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('ordem')->unique();
            $table->text('texto');
            $table->json('opcoes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};
