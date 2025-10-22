<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = [
        'name',
        'specification',
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
