<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'brand_id',
        'phone_model_id',
        'color_id',
        'storage_id',
        'images',
        'is_featured',
        'is_sold',
        'sold_at',
        'repurchased_at',
        'repurchase_price',
        'stock_serial',
        'condition',
        'origin',
        'notes',
        'customer_info'
    ];

    protected $casts = [
        'images' => 'array',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'repurchase_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_sold' => 'boolean',
        'sold_at' => 'datetime',
        'repurchased_at' => 'datetime'
    ];

    // Relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function phoneModel()
    {
        return $this->belongsTo(PhoneModel::class, 'phone_model_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function customerRecords()
    {
        return $this->hasMany(CustomerRecord::class);
    }
}
