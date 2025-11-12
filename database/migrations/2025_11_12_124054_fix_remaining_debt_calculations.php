<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix remaining_debt calculations for all customer records
        // Recalculate remaining_debt based on sale_price and paid_amount
        DB::statement('
            UPDATE customer_records 
            SET remaining_debt = GREATEST(0, ROUND(sale_price - paid_amount, 2)),
                payment_status = CASE 
                    WHEN ROUND(sale_price - paid_amount, 2) <= 0.01 THEN "paid"
                    WHEN paid_amount > 0 THEN "partial"
                    ELSE "pending"
                END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration fixes data, so there's nothing to reverse
    }
};
