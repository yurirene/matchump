<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discovery_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('viewer_id')->constrained('match_users')->cascadeOnDelete();
            $table->foreignUuid('target_id')->constrained('match_users')->cascadeOnDelete();
            $table->string('action', 16);
            $table->timestamps();

            $table->unique(['viewer_id', 'target_id']);
            $table->index('viewer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discovery_interactions');
    }
};
