<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = $request->attributes->get('current_admin') ?: Admin::current();

        if (!$admin || !$admin->is_active) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yetkisiz erişim: Giriş yapmalısınız.'
                ], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Lütfen giriş yapınız.');
        }

        if (!$admin->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Bu işlem ({$permission}) için yetkiniz bulunmamaktadır."
                ], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz bulunmamaktadır.');
        }

        return $next($request);
    }
}
