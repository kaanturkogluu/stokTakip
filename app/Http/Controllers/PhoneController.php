<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function index()
    {
        $phones = Phone::with(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery'])
                      ->where('is_featured', true)
                      ->take(6)
                      ->get();
        return view('home', compact('phones'));
    }

    public function phones()
    {
        $phones = Phone::with(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery'])
                      ->where('is_sold', false)
                      ->orderBy('created_at', 'desc')
                      ->paginate(12);
        return view('phones.index', compact('phones'));
    }

    public function show(Phone $phone)
    {
        $phone->load(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery']);
        return view('phones.show', compact('phone'));
    }

    public function contact()
    {
        return view('contact');
    }
}
