<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Phone;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Basit admin kontrolü (gerçek uygulamada veritabanı kullanılmalı)
        if ($credentials['email'] === 'admin@macrotech.com' && $credentials['password'] === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Giriş bilgileri hatalı.',
        ]);
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $phones = Phone::all();
        $totalPhones = Phone::count();
        $featuredPhones = Phone::where('is_featured', true)->count();

        return view('admin.dashboard', compact('phones', 'totalPhones', 'featuredPhones'));
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.phones.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'memory' => 'nullable|string|max:255',
            'ram' => 'required|string|max:255',
            'screen_size' => 'required|string|max:255',
            'camera' => 'required|string|max:255',
            'battery' => 'required|string|max:255',
            'os' => 'required|string|max:255',
            'condition' => 'required|in:sifir,ikinci_el',
            'origin' => 'required|in:yurtdisi,turkiye',
            'stock_serial' => 'nullable|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string'
        ]);

        $phoneData = $request->all();
        
        // Default image if no images provided
        if (empty($phoneData['images'])) {
            $phoneData['images'] = ['/images/default-phone.svg'];
        }

        Phone::create($phoneData);

        return redirect()->route('admin.dashboard')->with('success', 'Telefon başarıyla eklendi!');
    }
}
