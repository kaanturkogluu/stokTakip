<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\Phone;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Color;
use App\Models\Storage as StorageModel;

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

        $totalPhones = Phone::count();
        $featuredPhones = Phone::where('is_featured', true)->count();
        $soldPhones = Phone::where('is_sold', true)->count();
        $availablePhones = Phone::where('is_sold', false)->count();

        return view('admin.dashboard', compact(
            'totalPhones', 'featuredPhones', 
            'soldPhones', 'availablePhones'
        ));
    }

    public function phones(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Phone::with(['brand', 'phoneModel', 'color', 'storage']);

        // Arama fonksiyonalitesi
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('stock_serial', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Satış durumu filtresi
        if ($request->filled('sale_status_filter')) {
            $saleStatus = $request->get('sale_status_filter');
            if ($saleStatus === 'sold') {
                $query->where('is_sold', true);
            } elseif ($saleStatus === 'not_sold') {
                $query->where('is_sold', false);
            }
        }

        // Durum filtresi
        if ($request->filled('condition_filter')) {
            $query->where('condition', $request->get('condition_filter'));
        }

        // Öne çıkan filtresi
        if ($request->filled('featured_filter')) {
            $query->where('is_featured', $request->get('featured_filter'));
        }

        $phones = $query->orderBy('created_at', 'desc')->paginate(25);

        return view('admin.phones.index', compact('phones'));
    }

    public function getPhoneModelsByBrand(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $brandId = $request->get('brand_id');
        
        if (!$brandId) {
            return response()->json(['models' => []]);
        }

        $models = PhoneModel::where('brand_id', $brandId)
                           ->where('is_active', true)
                           ->select('id', 'name')
                           ->get();

        return response()->json(['models' => $models]);
    }

    public function getColorsByBrand(Request $request)
    {
        try {
            if (!session('admin_logged_in')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $brandId = $request->get('brand_id');
            
            if (!$brandId) {
                return response()->json(['colors' => []]);
            }

            $brand = Brand::find($brandId);
            if (!$brand) {
                return response()->json(['colors' => []]);
            }

            // Markaya ait renkleri getir
            $colors = $brand->colors()
                           ->where('is_active', true)
                           ->select('colors.id', 'colors.name', 'colors.hex_code')
                           ->get();

            return response()->json(['colors' => $colors]);
        } catch (\Exception $e) {
            Log::error('getColorsByBrand error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
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

        // Veritabanından verileri çek
        $brands = Brand::where('is_active', true)->get();
        $colors = Color::where('is_active', true)->get();
        $storages = StorageModel::where('is_active', true)->get();

        return view('admin.phones.create', compact(
            'brands', 'colors', 'storages'
        ));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'phone_model_id' => 'required|exists:phone_models,id',
            'color_id' => 'nullable|exists:colors,id',
            'storage_id' => 'required|exists:storages,id',
            'condition' => 'required|in:sifir,ikinci_el',
            'origin' => 'required|in:yurtdisi,turkiye',
            'stock_serials' => 'required|string',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string'
        ], [
            'name.required' => 'Telefon adı alanı zorunludur.',
            'name.string' => 'Telefon adı metin formatında olmalıdır.',
            'name.max' => 'Telefon adı en fazla 255 karakter olabilir.',
            'purchase_price.required' => 'Alış fiyatı alanı zorunludur.',
            'purchase_price.numeric' => 'Alış fiyatı sayısal bir değer olmalıdır.',
            'purchase_price.min' => 'Alış fiyatı 0\'dan küçük olamaz.',
            'sale_price.numeric' => 'Satış fiyatı sayısal bir değer olmalıdır.',
            'sale_price.min' => 'Satış fiyatı 0\'dan küçük olamaz.',
            'brand_id.required' => 'Marka seçimi zorunludur.',
            'brand_id.exists' => 'Seçilen marka geçersizdir.',
            'phone_model_id.required' => 'Model seçimi zorunludur.',
            'phone_model_id.exists' => 'Seçilen model geçersizdir.',
            'color_id.exists' => 'Seçilen renk geçersizdir.',
            'storage_id.required' => 'Depolama seçimi zorunludur.',
            'storage_id.exists' => 'Seçilen depolama geçersizdir.',
            'condition.required' => 'Durum seçimi zorunludur.',
            'condition.in' => 'Durum sıfır veya ikinci el olmalıdır.',
            'origin.required' => 'Menşei seçimi zorunludur.',
            'origin.in' => 'Menşei Türkiye veya yurtdışı olmalıdır.',
            'stock_serials.required' => 'En az bir seri numarası eklemelisiniz.',
            'stock_serials.string' => 'Seri numaraları metin formatında olmalıdır.',
            'is_featured.boolean' => 'Öne çıkan telefon değeri doğru/yanlış olmalıdır.',
            'images.array' => 'Resimler dizi formatında olmalıdır.',
            'images.*.string' => 'Resim URL\'leri metin formatında olmalıdır.'
        ]);

        // Seri numaralarını decode et
        $stockSerials = json_decode($request->stock_serials, true);
        
        if (empty($stockSerials) || !is_array($stockSerials)) {
            return redirect()->back()->withErrors(['stock_serials' => 'En az bir seri numarası eklemelisiniz.'])->withInput();
        }

        $phoneData = $request->except(['stock_serials']);
        
        // Default image if no images provided
        if (empty($phoneData['images'])) {
            $phoneData['images'] = ['/images/default-phone.svg'];
        }

        $createdCount = 0;
        
        // Her seri numarası için ayrı kayıt oluştur
        foreach ($stockSerials as $serialNumber) {
            $phoneData['stock_serial'] = $serialNumber;
            Phone::create($phoneData);
            $createdCount++;
        }

        $message = $createdCount > 1 
            ? "{$createdCount} adet telefon başarıyla eklendi!" 
            : "Telefon başarıyla eklendi!";

        return redirect()->route('admin.dashboard')->with('success', $message);
    }

    public function show(Phone $phone)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Telefon bilgilerini ilişkileriyle birlikte yükle
        $phone->load(['brand', 'phoneModel', 'color', 'storage']);

        return view('admin.phones.show', compact('phone'));
    }

    public function edit(Phone $phone)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Telefon bilgilerini ilişkileriyle birlikte yükle
        $phone->load(['brand', 'phoneModel', 'color', 'storage']);

        // Form için gerekli verileri yükle
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $colors = Color::where('is_active', true)->orderBy('name')->get();
        $storages = StorageModel::where('is_active', true)->orderBy('capacity_gb')->get();

        // Seçili markaya ait modelleri yükle
        $phoneModels = PhoneModel::where('brand_id', $phone->brand_id)
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->get();

        // Seçili markaya ait renkleri yükle
        $brandColors = $phone->brand->colors()
                                   ->where('is_active', true)
                                   ->orderBy('name')
                                   ->get();

        return view('admin.phones.edit', compact(
            'phone', 'brands', 'colors', 'storages',
            'phoneModels', 'brandColors'
        ));
    }

    public function update(Request $request, Phone $phone)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'phone_model_id' => 'required|exists:phone_models,id',
            'color_id' => 'required|exists:colors,id',
            'storage_id' => 'required|exists:storages,id',
            'condition' => 'required|in:sifir,ikinci_el',
            'origin' => 'required|in:yurtdisi,turkiye',
            'stock_serial' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_sold' => 'boolean',
            'sold_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string'
        ]);

        $phoneData = $request->all();
        $phoneData['is_featured'] = $request->has('is_featured');
        $phoneData['is_sold'] = $request->has('is_sold');

        // Satış tarihi kontrolü
        if (!$phoneData['is_sold']) {
            $phoneData['sold_at'] = null;
        } elseif ($phoneData['is_sold'] && !$phone->sold_at) {
            $phoneData['sold_at'] = now();
        }

        $phone->update($phoneData);

        return redirect()->route('admin.phones.show', $phone)->with('success', 'Telefon başarıyla güncellendi!');
    }

    public function destroy(Phone $phone)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $phoneName = $phone->name;
            $phone->delete();
            
            return redirect()->route('admin.phones.index')->with('success', "{$phoneName} başarıyla silindi!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Telefon silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    // Data Management Pages
    public function dataIndex()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.index');
    }

    public function brands()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $brands = Brand::withCount('phoneModels')->get();
        return view('admin.data.brands', compact('brands'));
    }

    public function phoneModels()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $phoneModels = PhoneModel::with('brand')->withCount('phones')->get();
        $brands = Brand::where('is_active', true)->get();
        return view('admin.data.phone-models', compact('phoneModels', 'brands'));
    }

    public function colors()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $colors = Color::withCount('phones')->get();
        return view('admin.data.colors', compact('colors'));
    }

    public function storages()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $storages = StorageModel::withCount('phones')->get();
        return view('admin.data.storages', compact('storages'));
    }



    // Create Methods
    public function createBrand()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.brands.create');
    }

    public function storeBrand(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        Brand::create($request->all());

        return redirect()->route('admin.data.brands')->with('success', 'Marka başarıyla eklendi!');
    }

    public function editBrand(Brand $brand)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Brand'i phone models count ile birlikte yükle
        $brand->loadCount('phoneModels');
        
        $colors = Color::where('is_active', true)->get();
        $selectedColors = $brand->colors->pluck('id')->toArray();

        return view('admin.data.brands.edit', compact('brand', 'colors', 'selectedColors'));
    }

    public function updateBrand(Request $request, Brand $brand)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $brand->update($data);

        // Renk eşleştirmelerini güncelle
        if ($request->has('colors')) {
            $brand->colors()->sync($request->colors);
        } else {
            $brand->colors()->detach();
        }

        return redirect()->route('admin.data.brands')->with('success', 'Marka başarıyla güncellendi!');
    }

    public function createColor()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.colors.create');
    }

    public function storeColor(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:colors',
            'hex_code' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        Color::create($request->all());

        return redirect()->route('admin.data.colors')->with('success', 'Renk başarıyla eklendi!');
    }

    public function editColor(Color $color)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.colors.edit', compact('color'));
    }

    public function updateColor(Request $request, Color $color)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'hex_code' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $color->update($data);

        return redirect()->route('admin.data.colors')->with('success', 'Renk başarıyla güncellendi!');
    }

    public function createStorage()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.storages.create');
    }

    public function storeStorage(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:storages',
            'capacity_gb' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        StorageModel::create($request->all());

        return redirect()->route('admin.data.storages')->with('success', 'Depolama başarıyla eklendi!');
    }

    public function editStorage(StorageModel $storage)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.storages.edit', compact('storage'));
    }

    public function updateStorage(Request $request, StorageModel $storage)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:storages,name,' . $storage->id,
            'capacity_gb' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $storage->update($data);

        return redirect()->route('admin.data.storages')->with('success', 'Depolama başarıyla güncellendi!');
    }





    public function createPhoneModel()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $brands = Brand::where('is_active', true)->get();
        return view('admin.data.phone-models.create', compact('brands'));
    }

    public function storePhoneModel(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        PhoneModel::create($data);

        return redirect()->route('admin.data.phone-models')->with('success', 'Telefon modeli başarıyla eklendi!');
    }

    public function editPhoneModel(PhoneModel $phoneModel)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $brands = Brand::where('is_active', true)->get();
        return view('admin.data.phone-models.edit', compact('phoneModel', 'brands'));
    }

    public function updatePhoneModel(Request $request, PhoneModel $phoneModel)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $phoneModel->update($data);

        return redirect()->route('admin.data.phone-models')->with('success', 'Telefon modeli başarıyla güncellendi!');
    }


    // Sale functionality
    public function searchPhoneBySerial(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $serialNumber = $request->get('serial');
        
        if (!$serialNumber) {
            return response()->json(['success' => false, 'message' => 'Seri numarası gerekli']);
        }

        $phone = Phone::with(['brand', 'phoneModel', 'color', 'storage'])
                     ->where('stock_serial', 'LIKE', "%{$serialNumber}%")
                     ->first();

        if ($phone) {
            return response()->json([
                'success' => true,
                'phone' => $phone
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Bu seri numarasına sahip cihaz bulunamadı'
        ]);
    }

    public function sellPhone(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'serial_number' => 'required|string',
            'sale_price' => 'required|numeric|min:0'
        ]);

        $phone = Phone::where('stock_serial', $request->serial_number)->first();

        if (!$phone) {
            return response()->json([
                'success' => false,
                'message' => 'Bu seri numarasına sahip cihaz bulunamadı'
            ]);
        }

        if ($phone->is_sold) {
            return response()->json([
                'success' => false,
                'message' => 'Bu cihaz zaten satılmış'
            ]);
        }

        // Update phone as sold
        $phone->update([
            'is_sold' => true,
            'sale_price' => $request->sale_price,
            'sold_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$phone->name} cihazı başarıyla satıldı. Satış fiyatı: " . number_format($request->sale_price, 2) . " ₺"
        ]);
    }

    // Settings functionality
    public function settings()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Get settings from database
        $settings = Setting::getAllAsArray();

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:500',
            'whatsapp_number' => 'nullable|string|max:20',
            'sales_phone' => 'nullable|string|max:20',
            'technical_phone' => 'nullable|string|max:20',
            'main_phone' => 'nullable|string|max:20',
            'working_hours_weekdays' => 'nullable|string|max:50',
            'working_hours_saturday' => 'nullable|string|max:50',
            'working_hours_sunday' => 'nullable|string|max:50',
            'whatsapp_support' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'google_maps_latitude' => 'nullable|numeric|between:-90,90',
            'google_maps_longitude' => 'nullable|numeric|between:-180,180',
            'google_maps_zoom' => 'nullable|integer|between:1,20',
        ]);

        // Save settings to database (logo and favicon are handled separately via file upload)
        $settingsToUpdate = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_address' => $request->contact_address,
            'whatsapp_number' => $request->whatsapp_number,
            'sales_phone' => $request->sales_phone,
            'technical_phone' => $request->technical_phone,
            'main_phone' => $request->main_phone,
            'working_hours_weekdays' => $request->working_hours_weekdays,
            'working_hours_saturday' => $request->working_hours_saturday,
            'working_hours_sunday' => $request->working_hours_sunday,
            'whatsapp_support' => $request->whatsapp_support,
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'twitter_url' => $request->twitter_url,
            'youtube_url' => $request->youtube_url,
            'google_maps_latitude' => $request->google_maps_latitude,
            'google_maps_longitude' => $request->google_maps_longitude,
            'google_maps_zoom' => $request->google_maps_zoom,
        ];

        foreach ($settingsToUpdate as $key => $value) {
            Setting::setValue($key, $value);
        }
        
        return redirect()->route('admin.settings')->with('success', 'Site ayarları başarıyla güncellendi!');
    }

    // Helper method to get settings (can be used across the application)
    public static function getSettings()
    {
        return Setting::getAllAsArray();
    }

    public function uploadLogo(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'logo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            // Delete old logo if exists
            $oldLogo = Setting::getValue('site_logo');
            if ($oldLogo && Storage::disk('public')->exists(str_replace('/storage/', '', $oldLogo))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldLogo));
            }

            // Store new logo
            $path = $request->file('logo')->store('logos', 'public');
            $url = '/storage/' . $path;

            // Update setting
            Setting::setValue('site_logo', $url);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Logo başarıyla yüklendi!'
            ]);

        } catch (\Exception $e) {
            Log::error('Logo upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Logo yüklenirken bir hata oluştu!'
            ], 500);
        }
    }

    public function uploadFavicon(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'favicon' => 'required|file|mimes:jpeg,png,jpg,gif,svg,ico|max:1024'
        ]);

        try {
            // Delete old favicon if exists
            $oldFavicon = Setting::getValue('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists(str_replace('/storage/', '', $oldFavicon))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldFavicon));
            }

            // Store new favicon
            $path = $request->file('favicon')->store('favicons', 'public');
            $url = '/storage/' . $path;

            // Update setting
            Setting::setValue('site_favicon', $url);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Favicon başarıyla yüklendi!'
            ]);

        } catch (\Exception $e) {
            Log::error('Favicon upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Favicon yüklenirken bir hata oluştu!'
            ], 500);
        }
    }

    public function reports()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Telefon istatistikleri
        $totalPhones = Phone::count();
        $soldPhones = Phone::where('is_sold', true)->count();
        $availablePhones = Phone::where('is_sold', false)->count();
        $featuredPhones = Phone::where('is_featured', true)->count();

        // Marka bazında istatistikler
        $brandStats = Phone::join('brands', 'phones.brand_id', '=', 'brands.id')
            ->selectRaw('brands.name, COUNT(*) as count')
            ->groupBy('brands.id', 'brands.name')
            ->orderBy('count', 'desc')
            ->get();

        // Durum bazında istatistikler
        $conditionStats = Phone::selectRaw('`condition`, COUNT(*) as count')
            ->groupBy('condition')
            ->get();

        // Menşei bazında istatistikler
        $originStats = Phone::selectRaw('origin, COUNT(*) as count')
            ->groupBy('origin')
            ->get();

        // Aylık satış istatistikleri (son 12 ay)
        $monthlySales = Phone::where('is_sold', true)
            ->where('sold_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(sold_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // En çok satılan telefonlar
        $topSellingPhones = Phone::where('is_sold', true)
            ->join('brands', 'phones.brand_id', '=', 'brands.id')
            ->join('phone_models', 'phones.phone_model_id', '=', 'phone_models.id')
            ->selectRaw('phones.name, brands.name as brand_name, phone_models.name as model_name, COUNT(*) as sales_count')
            ->groupBy('phones.name', 'brands.name', 'phone_models.name')
            ->orderBy('sales_count', 'desc')
            ->limit(10)
            ->get();

        // Detaylı rapor - Model bazında istatistikler
        $detailedReport = Phone::selectRaw('
                phone_models.name as model_name,
                brands.name as brand_name,
                COUNT(*) as total_count,
                SUM(CASE WHEN phones.is_sold = 1 THEN 1 ELSE 0 END) as sold_count,
                SUM(CASE WHEN phones.is_sold = 0 THEN 1 ELSE 0 END) as available_count
            ')
            ->join('phone_models', 'phones.phone_model_id', '=', 'phone_models.id')
            ->join('brands', 'phones.brand_id', '=', 'brands.id')
            ->groupBy('phone_models.id', 'phone_models.name', 'brands.name')
            ->orderBy('total_count', 'desc')
            ->get();

        return view('admin.reports', compact(
            'totalPhones',
            'soldPhones', 
            'availablePhones',
            'featuredPhones',
            'brandStats',
            'conditionStats',
            'originStats',
            'monthlySales',
            'topSellingPhones',
            'detailedReport'
        ));
    }
}
