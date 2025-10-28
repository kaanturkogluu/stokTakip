<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerRecord;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing customer debts to customer_records table
        $customers = Customer::where('debt', '>', 0)->get();
        
        foreach ($customers as $customer) {
            // Check if customer already has records
            $existingRecords = CustomerRecord::where('customer_id', $customer->id)->get();
            
            if ($existingRecords->isEmpty()) {
                // Create a general debt record for customers without any records
                CustomerRecord::create([
                    'customer_id' => $customer->id,
                    'phone_id' => null,
                    'sale_price' => $customer->debt,
                    'paid_amount' => 0,
                    'remaining_debt' => $customer->debt,
                    'payment_status' => 'pending',
                    'notes' => 'Manuel borç ekleme - Genel borç',
                    'created_at' => $customer->created_at,
                    'updated_at' => now()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove general debt records created by this migration
        CustomerRecord::where('notes', 'like', 'Manuel borç ekleme - Genel borç')
                    ->whereNull('phone_id')
                    ->delete();
    }
};
