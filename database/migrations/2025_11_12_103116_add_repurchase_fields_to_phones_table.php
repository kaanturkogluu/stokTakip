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
            $table->timestamp('repurchased_at')->nullable()->after('sold_at');
            $table->decimal('repurchase_price', 10, 2)->nullable()->after('repurchased_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->dropColumn(['repurchased_at', 'repurchase_price']);
        });
    }
};
