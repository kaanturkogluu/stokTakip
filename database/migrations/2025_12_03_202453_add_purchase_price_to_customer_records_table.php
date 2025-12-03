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
            $table->decimal('purchase_price_at_sale', 10, 2)->nullable()->after('sale_price');
        });
        
        // Mevcut kayıtlar için purchase_price_at_sale değerini telefonun mevcut purchase_price'ından doldur
        \DB::statement('
            UPDATE customer_records cr
            INNER JOIN phones p ON cr.phone_id = p.id
            SET cr.purchase_price_at_sale = p.purchase_price
            WHERE cr.phone_id IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_records', function (Blueprint $table) {
            $table->dropColumn('purchase_price_at_sale');
        });
    }
};
