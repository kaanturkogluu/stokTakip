<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battery extends Model
{
    protected $fillable = [
        'name',
        'capacity_mah',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
