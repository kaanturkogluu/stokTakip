<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function index()
    {
        $phones = Phone::where('is_featured', true)->take(6)->get();
        return view('home', compact('phones'));
    }

    public function phones()
    {
        $phones = Phone::all();
        return view('phones.index', compact('phones'));
    }

    public function show(Phone $phone)
    {
        return view('phones.show', compact('phone'));
    }

    public function contact()
    {
        return view('contact');
    }
}
