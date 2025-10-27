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
        // First, let's create customer records for existing sold phones
        $soldPhones = DB::table('phones')
            ->where('is_sold', true)
            ->whereNotNull('sale_price')
            ->get();

        foreach ($soldPhones as $phone) {
            // Check if there's already a customer record for this phone
            $existingRecord = DB::table('customer_records')
                ->where('phone_id', $phone->id)
                ->first();

            if (!$existingRecord) {
                // Create a default customer for sold phones without customer info
                $defaultCustomer = DB::table('customers')
                    ->where('name', 'Satış Kaydı')
                    ->where('surname', 'Müşteri')
                    ->first();

                if (!$defaultCustomer) {
                    $customerId = DB::table('customers')->insertGetId([
                        'name' => 'Satış Kaydı',
                        'surname' => 'Müşteri',
                        'phone' => null,
                        'debt' => 0,
                        'notes' => 'Mevcut satış kayıtları için oluşturuldu',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $customerId = $defaultCustomer->id;
                }

                // Create customer record for the sold phone
                DB::table('customer_records')->insert([
                    'customer_id' => $customerId,
                    'phone_id' => $phone->id,
                    'sale_price' => $phone->sale_price,
                    'paid_amount' => $phone->sale_price, // Assume full payment for existing records
                    'remaining_debt' => 0,
                    'payment_status' => 'paid',
                    'notes' => 'Mevcut satış kaydından taşındı',
                    'created_at' => $phone->updated_at ?? $phone->created_at,
                    'updated_at' => now(),
                ]);
            }
        }

        // Now, let's migrate existing customer payments to customer records
        $customerPayments = DB::table('customer_payments')->get();

        foreach ($customerPayments as $payment) {
            // Find the customer
            $customer = DB::table('customers')->find($payment->customer_id);
            
            if ($customer) {
                // Check if this payment is related to a phone sale
                // We'll create a generic record for payments without phone context
                $existingRecord = DB::table('customer_records')
                    ->where('customer_id', $payment->customer_id)
                    ->where('notes', 'like', '%' . $payment->notes . '%')
                    ->first();

                if (!$existingRecord) {
                    // Create a customer record for this payment
                    $salePrice = $payment->previous_debt + $payment->amount;
                    $remainingDebt = $payment->remaining_debt;
                    $paidAmount = $payment->amount;
                    
                    $paymentStatus = 'paid';
                    if ($remainingDebt > 0) {
                        $paymentStatus = $paidAmount > 0 ? 'partial' : 'pending';
                    }

                    DB::table('customer_records')->insert([
                        'customer_id' => $payment->customer_id,
                        'phone_id' => null, // No specific phone for general payments
                        'sale_price' => $salePrice,
                        'paid_amount' => $paidAmount,
                        'remaining_debt' => $remainingDebt,
                        'payment_status' => $paymentStatus,
                        'notes' => $payment->notes,
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);
                }
            }
        }

        // Update customer debt based on customer records
        $customers = DB::table('customers')->get();
        
        foreach ($customers as $customer) {
            $totalDebt = DB::table('customer_records')
                ->where('customer_id', $customer->id)
                ->sum('remaining_debt');
            
            DB::table('customers')
                ->where('id', $customer->id)
                ->update(['debt' => $totalDebt]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove migrated customer records
        DB::table('customer_records')->truncate();
        
        // Reset customer debt to original values
        DB::table('customers')->update(['debt' => 0]);
    }
};