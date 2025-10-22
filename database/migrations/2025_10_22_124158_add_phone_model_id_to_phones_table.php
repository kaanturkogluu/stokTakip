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
            // Eğer model_id varsa onu kaldır ve phone_model_id ekle
            if (Schema::hasColumn('phones', 'model_id')) {
                $table->dropForeign(['model_id']);
                $table->dropColumn('model_id');
            }
            
            // phone_model_id sütununu ekle
            $table->foreignId('phone_model_id')->constrained('phone_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            // phone_model_id sütununu kaldır
            $table->dropForeign(['phone_model_id']);
            $table->dropColumn('phone_model_id');
            
            // model_id sütununu geri ekle
            $table->foreignId('model_id')->constrained('phone_models')->onDelete('cascade');
        });
    }
};
