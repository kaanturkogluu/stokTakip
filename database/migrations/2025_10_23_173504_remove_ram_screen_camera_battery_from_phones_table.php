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
        Schema::table('phones', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['ram_id']);
            $table->dropForeign(['screen_id']);
            $table->dropForeign(['camera_id']);
            $table->dropForeign(['battery_id']);
            
            // Drop the columns
            $table->dropColumn(['ram_id', 'screen_id', 'camera_id', 'battery_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            // Add back the columns
            $table->foreignId('ram_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('screen_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('camera_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('battery_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
