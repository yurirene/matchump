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
        Schema::create('aprovacao_atas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('ata_id')->constrained('atas')->onDelete('cascade');
            $table->foreignUuid('delegado_id')->constrained('delegados')->onDelete('cascade');
            $table->boolean('aprovado')->default(false);
            $table->string('observacao')->nullable();
            $table->uuid('tenant_id');
            $table->uuid('reuniao_id');

            $table->timestamps();

            $table->unique(['ata_id', 'delegado_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprovacao_atas');
    }
};
