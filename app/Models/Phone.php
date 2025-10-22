<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'brand',
        'model',
        'color',
        'storage',
        'ram',
        'screen_size',
        'camera',
        'battery',
        'os',
        'images',
        'whatsapp_number',
        'is_featured',
        'stock_serial',
        'memory',
        'condition',
        'origin',
        'notes'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean'
    ];
}
