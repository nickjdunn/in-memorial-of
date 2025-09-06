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
            $table->date('date_of_birth')->nullable()->change();
            $table->date('date_of_passing')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memorials', function (Blueprint $table) {
            // Revert back to not nullable if we roll back
            $table->date('date_of_birth')->nullable(false)->change();
            $table->date('date_of_passing')->nullable(false)->change();
        });
    }
};