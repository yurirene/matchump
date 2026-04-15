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
        Schema::create('reunioes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->year('ano');
            $table->string('codigo')->unique();
            $table->boolean('status')->default(true);
            $table->uuid('tenant_id');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['ano', 'tenant_id']);
            $table->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunioes');
    }
};
