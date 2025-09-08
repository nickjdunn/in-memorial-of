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
        Schema::table('memorials', function (Blueprint $table) {
            $table->boolean('tributes_enabled')->default(true)->after('photo_shape');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memorials', function (Blueprint $table) {
            $table->dropColumn('tributes_enabled');
        });
    }
};