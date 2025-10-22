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
            // Remove old columns
            $table->dropColumn(['brand', 'model', 'color', 'storage', 'memory', 'ram', 'screen_size', 'camera', 'battery']);
            
            // Add foreign key columns
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('phone_model_id')->constrained('phone_models')->onDelete('cascade');
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->foreignId('storage_id')->constrained()->onDelete('cascade');
            $table->foreignId('ram_id')->constrained()->onDelete('cascade');
            $table->foreignId('screen_id')->constrained()->onDelete('cascade');
            $table->foreignId('camera_id')->constrained()->onDelete('cascade');
            $table->foreignId('battery_id')->constrained()->onDelete('cascade');
            
            // Rename price to purchase_price and add sale_price
            $table->renameColumn('price', 'purchase_price');
            $table->decimal('sale_price', 10, 2)->nullable()->after('purchase_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            // Remove foreign key columns
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['phone_model_id']);
            $table->dropForeign(['color_id']);
            $table->dropForeign(['storage_id']);
            $table->dropForeign(['ram_id']);
            $table->dropForeign(['screen_id']);
            $table->dropForeign(['camera_id']);
            $table->dropForeign(['battery_id']);
            
            $table->dropColumn(['brand_id', 'phone_model_id', 'color_id', 'storage_id', 'ram_id', 'screen_id', 'camera_id', 'battery_id']);
            
            // Add back old columns
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->string('storage');
            $table->string('memory')->nullable();
            $table->string('ram');
            $table->string('screen_size');
            $table->string('camera');
            $table->string('battery');
            
            // Rename back price column
            $table->renameColumn('purchase_price', 'price');
            $table->dropColumn('sale_price');
        });
    }
};
