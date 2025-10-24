<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $fillable = [
        'customer_id',
        'amount',
        'previous_debt',
        'remaining_debt',
        'payment_method',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'previous_debt' => 'decimal:2',
        'remaining_debt' => 'decimal:2'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Get formatted amount
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ₺';
    }

    // Get formatted previous debt
    public function getFormattedPreviousDebtAttribute()
    {
        return number_format($this->previous_debt, 2) . ' ₺';
    }

    // Get formatted remaining debt
    public function getFormattedRemainingDebtAttribute()
    {
        return number_format($this->remaining_debt, 2) . ' ₺';
    }

    // Get payment method in Turkish
    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'cash' => 'Nakit',
            'bank_transfer' => 'Banka Havalesi',
            'card' => 'Kart',
            'other' => 'Diğer'
        ];

        return $methods[$this->payment_method] ?? 'Bilinmiyor';
    }
}