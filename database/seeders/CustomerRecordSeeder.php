<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Phone;
use App\Models\CustomerRecord;

class CustomerRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some customers and phones for sample records
        $customers = Customer::take(5)->get();
        $phones = Phone::where('is_sold', false)->take(3)->get();
        
        if ($customers->count() > 0 && $phones->count() > 0) {
            // Create sample customer records
            foreach ($customers as $index => $customer) {
                if ($index < $phones->count()) {
                    $phone = $phones[$index];
                    $salePrice = rand(5000, 15000);
                    $paidAmount = rand(1000, $salePrice);
                    $remainingDebt = $salePrice - $paidAmount;
                    
                    $paymentStatus = 'paid';
                    if ($remainingDebt > 0) {
                        $paymentStatus = $paidAmount > 0 ? 'partial' : 'pending';
                    }
                    
                    CustomerRecord::create([
                        'customer_id' => $customer->id,
                        'phone_id' => $phone->id,
                        'sale_price' => $salePrice,
                        'paid_amount' => $paidAmount,
                        'remaining_debt' => $remainingDebt,
                        'payment_status' => $paymentStatus,
                        'notes' => 'Örnek satış kaydı'
                    ]);
                    
                    // Mark phone as sold
                    $phone->update([
                        'is_sold' => true,
                        'sale_price' => $salePrice
                    ]);
                }
            }
        }
        
        // Update customer debt totals
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $totalDebt = $customer->records()->sum('remaining_debt');
            $customer->update(['debt' => $totalDebt]);
        }
    }
}