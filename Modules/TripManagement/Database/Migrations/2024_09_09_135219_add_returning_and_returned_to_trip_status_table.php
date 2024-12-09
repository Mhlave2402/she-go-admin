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
        Schema::table('trip_status', function (Blueprint $table) {
            $table->timestamp('returning')->nullable();
            $table->timestamp('returned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_status', function (Blueprint $table) {
            $table->dropColumn(['returning','returned']);
        });
    }
};