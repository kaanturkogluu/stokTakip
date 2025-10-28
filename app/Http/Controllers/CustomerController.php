<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\CustomerRecord;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Customer::with('records');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Debt filter
        if ($request->filled('debt_filter')) {
            if ($request->debt_filter === 'has_debt') {
                $query->whereHas('records', function($q) {
                    $q->where('remaining_debt', '>', 0);
                });
            } elseif ($request->debt_filter === 'no_debt') {
                $query->whereDoesntHave('records', function($q) {
                    $q->where('remaining_debt', '>', 0);
                });
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        switch ($sortBy) {
            case 'debt':
                $query->orderByRaw('(SELECT SUM(remaining_debt) FROM customer_records WHERE customer_records.customer_id = customers.id) DESC');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $customers = $query->paginate(15);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'debt' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Create customer
        $customer = Customer::create($request->all());

        // If debt amount is greater than 0, create a customer record for the debt
        if ($request->debt > 0) {
            CustomerRecord::create([
                'customer_id' => $customer->id,
                'phone_id' => null, // No specific phone for general debt
                'sale_price' => $request->debt,
                'paid_amount' => 0,
                'remaining_debt' => $request->debt,
                'payment_status' => 'pending',
                'notes' => 'Manuel borç ekleme - ' . ($request->notes ?: 'Genel borç')
            ]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Müşteri başarıyla eklendi!');
    }

    public function show(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customer->load(['payments', 'records.phone.brand', 'records.phone.phoneModel', 'records.phone.storage']);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'debt' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $customer->update($request->all());

        // Update customer debt record if debt amount changed
        $currentTotalDebt = $customer->total_debt;
        $newDebtAmount = $request->debt;
        
        if ($newDebtAmount > $currentTotalDebt) {
            // Add new debt record for the difference
            $debtDifference = $newDebtAmount - $currentTotalDebt;
            CustomerRecord::create([
                'customer_id' => $customer->id,
                'phone_id' => null, // No specific phone for general debt
                'sale_price' => $debtDifference,
                'paid_amount' => 0,
                'remaining_debt' => $debtDifference,
                'payment_status' => 'pending',
                'notes' => 'Manuel borç ekleme - ' . ($request->notes ?: 'Genel borç')
            ]);
        }

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Müşteri bilgileri başarıyla güncellendi!');
    }

    public function destroy(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Müşteri başarıyla silindi!');
    }

    // Payment methods
    public function payment(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.customers.payment', compact('customer'));
    }

    public function getDebts(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $customer->load(['records.phone.brand', 'records.phone.phoneModel', 'records.phone.storage']);
        
        // Format customer data for JSON response
        $customerData = [
            'id' => $customer->id,
            'name' => $customer->name,
            'surname' => $customer->surname,
            'phone' => $customer->phone,
            'debt' => $customer->debt,
            'total_debt' => $customer->total_debt,
            'formatted_total_debt' => $customer->formatted_total_debt,
            'notes' => $customer->notes,
            'created_at' => $customer->created_at,
            'updated_at' => $customer->updated_at
        ];
        
        // Format debts data for JSON response
        $debtsData = $customer->records->map(function($record) {
            return [
                'id' => $record->id,
                'customer_id' => $record->customer_id,
                'phone_id' => $record->phone_id,
                'sale_price' => $record->sale_price,
                'paid_amount' => $record->paid_amount,
                'remaining_debt' => $record->remaining_debt,
                'payment_status' => $record->payment_status,
                'notes' => $record->notes,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
                'formatted_sale_price' => $record->formatted_sale_price,
                'formatted_paid_amount' => $record->formatted_paid_amount,
                'formatted_remaining_debt' => $record->formatted_remaining_debt,
                'payment_status_text' => $record->payment_status_text,
                'payment_status_color' => $record->payment_status_color,
                'device_info' => $record->device_info,
                'phone' => $record->phone ? [
                    'id' => $record->phone->id,
                    'name' => $record->phone->name,
                    'brand' => $record->phone->brand ? [
                        'id' => $record->phone->brand->id,
                        'name' => $record->phone->brand->name
                    ] : null,
                    'phoneModel' => $record->phone->phoneModel ? [
                        'id' => $record->phone->phoneModel->id,
                        'name' => $record->phone->phoneModel->name
                    ] : null,
                    'storage' => $record->phone->storage ? [
                        'id' => $record->phone->storage->id,
                        'name' => $record->phone->storage->name
                    ] : null
                ] : null
            ];
        });
        
        return response()->json([
            'success' => true,
            'customer' => $customerData,
            'debts' => $debtsData
        ]);
    }

    public function processPayment(Request $request, Customer $customer)
    {
        if (!session('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,iban,credit_card',
            'notes' => 'nullable|string|max:1000'
        ]);

        $amount = $request->amount;
        $paymentMethod = $request->payment_method;
        $notes = $request->notes;

        // Check if payment amount is valid
        if ($amount > $customer->total_debt) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Ödeme tutarı toplam borçtan fazla olamaz.'
                ], 400);
            }
            return back()->withErrors(['amount' => 'Ödeme tutarı toplam borçtan fazla olamaz.']);
        }

        // Get payment method text
        $paymentMethodText = [
            'cash' => 'Nakit',
            'iban' => 'IBAN',
            'credit_card' => 'Kredi Kartı'
        ][$paymentMethod] ?? 'Bilinmiyor';

        // Create payment record
        $payment = CustomerPayment::create([
            'customer_id' => $customer->id,
            'amount' => $amount,
            'previous_debt' => $customer->total_debt,
            'remaining_debt' => $customer->total_debt - $amount,
            'payment_method' => $paymentMethod,
            'notes' => $notes ?: "Ödeme alındı - {$paymentMethodText}"
        ]);

        // Update customer records with payment
        $remainingAmount = $amount;
        $customerRecords = $customer->records()->where('remaining_debt', '>', 0)->orderBy('created_at')->get();
        
        foreach ($customerRecords as $record) {
            if ($remainingAmount <= 0) break;
            
            $paymentToRecord = min($remainingAmount, $record->remaining_debt);
            $record->paid_amount += $paymentToRecord;
            $record->remaining_debt -= $paymentToRecord;
            
            // Update payment status
            if ($record->remaining_debt <= 0) {
                $record->payment_status = 'paid';
            } else {
                $record->payment_status = 'partial';
            }
            
            $record->save();
            $remainingAmount -= $paymentToRecord;
        }

        // Update customer total debt
        $customer->update(['debt' => $customer->total_debt]);

        // Prepare response
        $message = "Ödeme başarıyla kaydedildi. Tutar: " . number_format($amount, 2) . " ₺ - " . $paymentMethodText;
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'payment' => $payment
            ]);
        }
        
        return redirect()->route('admin.customers.show', $customer)->with('success', $message);
    }
}