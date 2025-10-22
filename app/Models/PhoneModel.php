<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhoneModel extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'phone_model_id');
    }
}
