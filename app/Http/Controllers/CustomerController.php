<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customers = Customer::orderBy('name')->paginate(15);
        
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

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Müşteri başarıyla eklendi!');
    }

    public function show(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customer->load('payments');
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
    public function paymentForm(Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.customers.payment', compact('customer'));
    }

    public function processPayment(Request $request, Customer $customer)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,card,other',
            'notes' => 'nullable|string|max:1000'
        ]);

        $paymentAmount = $request->amount;
        $previousDebt = $customer->debt;
        $remainingDebt = max(0, $previousDebt - $paymentAmount);

        // Create payment record
        CustomerPayment::create([
            'customer_id' => $customer->id,
            'amount' => $paymentAmount,
            'previous_debt' => $previousDebt,
            'remaining_debt' => $remainingDebt,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes
        ]);

        // Update customer debt
        $customer->update(['debt' => $remainingDebt]);

        return redirect()->route('admin.customers.show', $customer)->with('success', 
            'Ödeme başarıyla kaydedildi! Ödenen: ' . number_format($paymentAmount, 2) . ' ₺');
    }
}