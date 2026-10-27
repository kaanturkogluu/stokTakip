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
        $request = $request ?: request();
        $isJson = $request && (
            $request->expectsJson() ||
            $request->isJson() ||
            $request->ajax() ||
            $request->wantsJson() ||
            $request->header('X-Requested-With') === 'XMLHttpRequest' ||
            str_contains((string)$request->header('Content-Type'), 'json') ||
            str_contains((string)$request->header('Accept'), 'json')
        );

        if (!session('admin_logged_in')) {
            if ($isJson) {
                return response()->json(['success' => false, 'message' => 'Giriş yapmalısınız.', 'error' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::current();
        if (!$currentAdmin || !$currentAdmin->is_active) {
            session()->flush();
            if ($isJson) {
                return response()->json(['success' => false, 'message' => 'Oturumunuz sonlandırılmış.', 'error' => 'Forbidden'], 403);
            }
            return redirect()->route('admin.login')->withErrors(['email' => 'Hesabınız aktif değil veya silinmiş.']);
        }

        if (!$currentAdmin->hasPermission($permission)) {
            if ($isJson) {
                return response()->json(['success' => false, 'message' => 'Bu işlem için yetkiniz bulunmamaktadır.', 'error' => 'Forbidden'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz bulunmamaktadır.');
        }

        return null;
    }
}
