<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'phone',
        'debt',
        'notes'
    ];

    protected $casts = [
        'debt' => 'decimal:2'
    ];

    // Get full name
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    // Get formatted debt
    public function getFormattedDebtAttribute()
    {
        return number_format($this->debt, 2) . ' ₺';
    }

    // Relationships
    public function payments()
    {
        return $this->hasMany(CustomerPayment::class);
    }

    public function records()
    {
        return $this->hasMany(CustomerRecord::class);
    }

    // Calculate total debt from records
    public function getTotalDebtAttribute()
    {
        return $this->records()->sum('remaining_debt');
    }

    // Get formatted total debt
    public function getFormattedTotalDebtAttribute()
    {
        return number_format($this->total_debt, 2) . ' ₺';
    }
}
