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
        Schema::table('customer_records', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['customer_id']);
            
            // Make customer_id nullable
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            
            // Re-add foreign key constraint with nullable
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_records', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['customer_id']);
            
            // Make customer_id not nullable again
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            
            // Re-add foreign key constraint
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
};
