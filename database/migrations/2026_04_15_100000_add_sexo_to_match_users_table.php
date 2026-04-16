<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('match_users', function (Blueprint $table) {
            $table->string('sexo', 16)->nullable()->after('birth_date');
        });
    }

    public function down(): void
    {
        Schema::table('match_users', function (Blueprint $table) {
            $table->dropColumn('sexo');
        });
    }
};
