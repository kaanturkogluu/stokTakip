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
        if (Schema::hasColumn('phones', 'model_id')) {
            Schema::table('phones', function (Blueprint $table) {
                $table->dropForeign(['model_id']);
                $table->dropColumn('model_id');
            });
        }
        
        if (!Schema::hasColumn('phones', 'phone_model_id')) {
            Schema::table('phones', function (Blueprint $table) {
                $table->foreignId('phone_model_id')->constrained('phone_models')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('phones', 'phone_model_id')) {
            Schema::table('phones', function (Blueprint $table) {
                $table->dropForeign(['phone_model_id']);
                $table->dropColumn('phone_model_id');
            });
        }
        
        if (!Schema::hasColumn('phones', 'model_id')) {
            Schema::table('phones', function (Blueprint $table) {
                $table->foreignId('model_id')->constrained('phone_models')->onDelete('cascade');
            });
        }
    }
};
