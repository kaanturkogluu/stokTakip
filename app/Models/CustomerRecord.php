<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRecord extends Model
{
    protected $fillable = [
        'customer_id',
        'phone_id',
        'sale_price',
        'purchase_price_at_sale',
        'paid_amount',
        'remaining_debt',
        'payment_status',
        'notes'
    ];

    protected $casts = [
        'sale_price' => 'decimal:2',
        'purchase_price_at_sale' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_debt' => 'decimal:2'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    // Get device info for display
    public function getDeviceInfoAttribute()
    {
        if ($this->phone) {
            $deviceInfo = $this->phone->name;
            
            if ($this->phone->brand && $this->phone->phoneModel) {
                $deviceInfo = $this->phone->brand->name . ' ' . $this->phone->phoneModel->name;
            } elseif ($this->phone->brand) {
                $deviceInfo = $this->phone->brand->name . ' ' . $deviceInfo;
            }
            
            if ($this->phone->storage) {
                $deviceInfo .= ' ' . $this->phone->storage->name;
            }
            
            return $deviceInfo;
        }
        
        return 'Genel Ödeme';
    }

    // Get formatted sale price
    public function getFormattedSalePriceAttribute()
    {
        return number_format($this->sale_price, 2) . ' ₺';
    }

    // Get formatted paid amount
    public function getFormattedPaidAmountAttribute()
    {
        return number_format($this->paid_amount, 2) . ' ₺';
    }

    // Get formatted remaining debt
    public function getFormattedRemainingDebtAttribute()
    {
        return number_format($this->remaining_debt, 2) . ' ₺';
    }

    // Get payment status in Turkish
    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Beklemede',
            'partial' => 'Kısmi Ödeme',
            'paid' => 'Ödendi'
        ];

        return $statuses[$this->payment_status] ?? 'Bilinmiyor';
    }

    // Get payment status color
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'text-red-600',
            'partial' => 'text-yellow-600',
            'paid' => 'text-green-600'
        ];

        return $colors[$this->payment_status] ?? 'text-gray-600';
    }
}