<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'name',
        'size_inches',
        'resolution',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'size_inches' => 'decimal:1'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
