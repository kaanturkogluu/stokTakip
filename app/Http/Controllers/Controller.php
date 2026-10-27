<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Check if current session admin has the specified permission.
     * Returns a redirect or JSON response if unauthorized, or null if permitted.
     */
    protected function checkPermission($permission, Request $request = null)
    {
        if (!session('admin_logged_in')) {
            if ($request && $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Giriş yapmalısınız.', 'error' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::current();
        if (!$currentAdmin || !$currentAdmin->is_active) {
            session()->flush();
            if ($request && $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Oturumunuz sonlandırılmış.', 'error' => 'Forbidden'], 403);
            }
            return redirect()->route('admin.login')->withErrors(['email' => 'Hesabınız aktif değil veya silinmiş.']);
        }

        if (!$currentAdmin->hasPermission($permission)) {
            if ($request && $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bu işlem için yetkiniz bulunmamaktadır.', 'error' => 'Forbidden'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz bulunmamaktadır.');
        }

        return null;
    }
}
