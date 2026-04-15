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
        Schema::create('comissoes_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('comissao_id')->constrained('comissoes')->onDelete('cascade');
            $table->foreignUuid('documento_id')->constrained('documentos')->onDelete('cascade');
            $table->boolean('aprovado')->default(false);
            $table->uuid('tenant_id');
            $table->uuid('reuniao_id');

            $table->timestamps();

            $table->unique(['comissao_id', 'documento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comissoes_documentos');
    }
};
