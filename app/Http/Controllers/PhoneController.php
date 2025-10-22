<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Http\Controllers\AdminController;
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
        
        // İlgili telefonları getir (aynı marka veya model, mevcut telefon hariç)
        $relatedPhones = Phone::with(['brand', 'phoneModel', 'color', 'storage', 'ram'])
            ->where('id', '!=', $phone->id)
            ->where('is_sold', false)
            ->where(function($query) use ($phone) {
                $query->where('brand_id', $phone->brand_id)
                      ->orWhere('phone_model_id', $phone->phone_model_id);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('phones.show', compact('phone', 'relatedPhones'));
    }

    public function contact()
    {
        $settings = AdminController::getSettings();
        return view('contact', compact('settings'));
    }
}
