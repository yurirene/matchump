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
        Schema::create('presencas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('delegado_id')->constrained('delegados')->onDelete('cascade');
            $table->foreignUuid('sessao_id')->constrained('sessoes')->onDelete('cascade');
            $table->boolean('presente')->default(false);
            $table->uuid('tenant_id');
            $table->uuid('reuniao_id');

            $table->timestamps();

            $table->unique(['delegado_id', 'sessao_id']);
            $table->index('tenant_id');
            $table->index('reuniao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};
