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
            $table->string('stock_serial')->nullable()->after('whatsapp_number');
            $table->string('memory')->nullable()->after('storage');
            $table->enum('condition', ['sifir', 'ikinci_el'])->default('sifir')->after('price');
            $table->enum('origin', ['yurtdisi', 'turkiye'])->default('turkiye')->after('condition');
            $table->text('notes')->nullable()->after('origin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->dropColumn(['stock_serial', 'memory', 'condition', 'origin', 'notes']);
        });
    }
};
