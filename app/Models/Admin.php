<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'is_active',
        'last_login_at',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Set password mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relationships
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Role checks
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function isManager()
    {
        return in_array($this->role, ['super_admin', 'admin', 'manager']);
    }

    // Permission checks
    public function hasPermission($permission)
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check custom permissions
        if ($this->permissions && is_array($this->permissions)) {
            return in_array($permission, $this->permissions);
        }

        return false;
    }

    // Get role name in Turkish
    public function getRoleNameAttribute()
    {
        $roles = [
            'super_admin' => 'Süper Admin',
            'admin' => 'Admin',
            'manager' => 'Yönetici',
            'staff' => 'Personel'
        ];

        return $roles[$this->role] ?? 'Bilinmiyor';
    }
}
