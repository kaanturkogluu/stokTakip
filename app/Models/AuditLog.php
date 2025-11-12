<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    // Get action name in Turkish
    public function getActionNameAttribute()
    {
        $actions = [
            'create' => 'Oluşturma',
            'update' => 'Güncelleme',
            'delete' => 'Silme',
            'login' => 'Giriş',
            'logout' => 'Çıkış',
            'sale' => 'Satış',
            'repurchase' => 'Geri Alma',
            'payment' => 'Ödeme',
            'view' => 'Görüntüleme'
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }
}
