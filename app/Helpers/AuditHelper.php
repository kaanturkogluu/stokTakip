<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditHelper
{
    /**
     * Log an action
     */
    public static function log($action, $description, $model = null, $oldValues = null, $newValues = null)
    {
        $adminId = session('admin_id'); // Can be null for system operations
        
        try {
            AuditLog::create([
                'admin_id' => $adminId,
                'action' => $action,
                'model_type' => $model ? get_class($model) : null,
                'model_id' => $model ? $model->id : null,
                'description' => $description,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent()
            ]);
        } catch (\Exception $e) {
            // Silently fail if audit log table doesn't exist or other errors
            \Log::warning('Audit log failed: ' . $e->getMessage());
        }
    }

    /**
     * Log a create action
     */
    public static function logCreate($model, $description = null)
    {
        $description = $description ?? self::getModelName($model) . ' oluşturuldu';
        self::log('create', $description, $model, null, $model->toArray());
    }

    /**
     * Log an update action
     */
    public static function logUpdate($model, $oldValues, $description = null)
    {
        $description = $description ?? self::getModelName($model) . ' güncellendi';
        self::log('update', $description, $model, $oldValues, $model->getChanges());
    }

    /**
     * Log a delete action
     */
    public static function logDelete($model, $description = null)
    {
        $description = $description ?? self::getModelName($model) . ' silindi';
        self::log('delete', $description, $model, $model->toArray(), null);
    }

    /**
     * Log a sale action
     */
    public static function logSale($phone, $salePrice, $customer = null)
    {
        $description = $phone->name . ' cihazı ' . number_format($salePrice, 2) . ' ₺ karşılığında satıldı';
        if ($customer) {
            $description .= ' - Müşteri: ' . $customer->full_name;
        }
        self::log('sale', $description, $phone);
    }

    /**
     * Log a repurchase action
     */
    public static function logRepurchase($phone, $repurchasePrice)
    {
        $description = $phone->name . ' cihazı ' . number_format($repurchasePrice, 2) . ' ₺ karşılığında geri alındı';
        self::log('repurchase', $description, $phone);
    }

    /**
     * Log a payment action
     */
    public static function logPayment($customer, $amount)
    {
        $description = $customer->full_name . ' müşterisinden ' . number_format($amount, 2) . ' ₺ ödeme alındı';
        self::log('payment', $description, $customer);
    }

    /**
     * Log a login action
     */
    public static function logLogin($admin)
    {
        self::log('login', $admin->name . ' giriş yaptı', null);
    }

    /**
     * Log a logout action
     */
    public static function logLogout($admin)
    {
        self::log('logout', $admin->name . ' çıkış yaptı', null);
    }

    /**
     * Get model name for description
     */
    private static function getModelName($model)
    {
        $modelNames = [
            'App\Models\Phone' => 'Telefon',
            'App\Models\Customer' => 'Müşteri',
            'App\Models\Brand' => 'Marka',
            'App\Models\PhoneModel' => 'Model',
            'App\Models\Color' => 'Renk',
            'App\Models\Storage' => 'Depolama',
            'App\Models\Admin' => 'Admin'
        ];

        return $modelNames[get_class($model)] ?? class_basename($model);
    }
}

