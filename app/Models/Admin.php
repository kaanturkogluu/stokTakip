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

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public static function current()
    {
        $adminId = session('admin_id');
        return $adminId ? static::find($adminId) : null;
    }

    // Permission checks
    public function hasPermission($permission)
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin has all permissions except deleting other admins
        if ($this->role === 'admin') {
            if ($permission === 'admins.delete') {
                return false;
            }
            return true;
        }

        // Manager has general operations (phones, sales, customers, payments, reports, data)
        // Manager cannot manage admins, cannot view audit logs, cannot change store settings
        if ($this->role === 'manager') {
            $restrictedForManager = ['admins.manage', 'admins.delete', 'settings.manage', 'audit.view'];
            if (in_array($permission, $restrictedForManager)) {
                return false;
            }
            return true;
        }

        // Staff: Strictly restricted to permissions explicitly granted in $this->permissions
        $forbiddenForStaff = ['admins.manage', 'admins.delete', 'settings.manage', 'audit.view', 'data.manage'];
        if (in_array($permission, $forbiddenForStaff)) {
            return false;
        }

        if ($this->permissions && is_array($this->permissions)) {
            // Implicit view permissions for staff if they have any related action
            if ($permission === 'customers.view') {
                return in_array('customers.create', $this->permissions) ||
                       in_array('customers.update', $this->permissions) ||
                       in_array('payments.process', $this->permissions);
            }

            if ($permission === 'phones.view') {
                return in_array('phones.create', $this->permissions) ||
                       in_array('phones.update', $this->permissions) ||
                       in_array('phones.delete', $this->permissions) ||
                       in_array('sales.create', $this->permissions);
            }

            if ($permission === 'sales.view') {
                return in_array('sales.create', $this->permissions);
            }

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
