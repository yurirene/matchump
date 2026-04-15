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
        Schema::create('delegados', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome');
            $table->string('cpf', 500);
            $table->string('hash_cpf');
            $table->string('telefone', 500)->nullable();
            $table->enum('cargo', [1, 2])->nullable();
            $table->enum('tipo', [1, 2, 3, 4])->default(1);
            $table->string('url_credencial')->nullable();
            $table->boolean('status')->default(true);
            $table->uuid('unidade_id');
            $table->uuid('tenant_id');
            $table->uuid('reuniao_id');
            $table->timestamps();

            $table->index('unidade_id');
            $table->index('tenant_id');
            $table->index('reuniao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegados');
    }
};
