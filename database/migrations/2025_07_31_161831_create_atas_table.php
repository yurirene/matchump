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
        Schema::create('atas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome');
            $table->string('url');
            $table->boolean('aprovada')->default(false);
            $table->foreignUuid('reuniao_id')->constrained('reunioes')->onDelete('cascade');
            $table->uuid('tenant_id');
            $table->timestamps();

            $table->index('reuniao_id');
            $table->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atas');
    }
};
