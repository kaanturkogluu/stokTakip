<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    protected $fillable = [
        'name',
        'capacity_gb',
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
