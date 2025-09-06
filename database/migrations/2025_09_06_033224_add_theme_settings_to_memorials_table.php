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
            $table->string('primary_color')->default('#0d9488')->after('slug'); // Default Teal
            $table->string('font_family_name')->default('Playfair Display')->after('primary_color');
            $table->string('font_family_body')->default('Lora')->after('font_family_name');
            $table->string('photo_shape')->default('rounded-full')->after('font_family_body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memorials', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'font_family_name', 'font_family_body', 'photo_shape']);
        });
    }
};