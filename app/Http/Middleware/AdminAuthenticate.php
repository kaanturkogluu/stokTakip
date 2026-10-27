<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in') || !session('admin_id')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lütfen giriş yapınız (Oturum bulunamadı).'
                ], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Bu sayfayı görüntülemek için giriş yapmalısınız.');
        }

        $admin = Admin::find(session('admin_id'));

        if (!$admin || !$admin->is_active) {
            session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hesabınız aktif değil veya silinmiş.'
                ], 403);
            }
            return redirect()->route('admin.login')->with('error', 'Hesabınız devre dışı bırakılmış veya geçerli değil.');
        }

        // Paylaşım için request objesine set et
        $request->attributes->set('current_admin', $admin);

        return $next($request);
    }
}
