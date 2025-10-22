<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Phone;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Color;
use App\Models\Storage;
use App\Models\Ram;
use App\Models\Screen;
use App\Models\Camera;
use App\Models\Battery;

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

    public function phones(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Phone::with(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery']);

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
            \Log::error('getColorsByBrand error: ' . $e->getMessage());
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
        $storages = Storage::where('is_active', true)->get();
        $rams = Ram::where('is_active', true)->get();
        $screens = Screen::where('is_active', true)->get();
        $cameras = Camera::where('is_active', true)->get();
        $batteries = Battery::where('is_active', true)->get();

        return view('admin.phones.create', compact(
            'brands', 'colors', 'storages', 
            'rams', 'screens', 'cameras', 'batteries'
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
            'color_id' => 'required|exists:colors,id',
            'storage_id' => 'required|exists:storages,id',
            'ram_id' => 'required|exists:rams,id',
            'screen_id' => 'required|exists:screens,id',
            'camera_id' => 'required|exists:cameras,id',
            'battery_id' => 'required|exists:batteries,id',
            'condition' => 'required|in:sifir,ikinci_el',
            'origin' => 'required|in:yurtdisi,turkiye',
            'stock_serials' => 'required|string',
            'notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string'
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
        $phone->load(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery']);

        return view('admin.phones.show', compact('phone'));
    }

    public function edit(Phone $phone)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Telefon bilgilerini ilişkileriyle birlikte yükle
        $phone->load(['brand', 'phoneModel', 'color', 'storage', 'ram', 'screen', 'camera', 'battery']);

        // Form için gerekli verileri yükle
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $colors = Color::where('is_active', true)->orderBy('name')->get();
        $storages = Storage::where('is_active', true)->orderBy('capacity_gb')->get();
        $rams = Ram::where('is_active', true)->orderBy('capacity_gb')->get();
        $screens = Screen::where('is_active', true)->orderBy('size_inches')->get();
        $cameras = Camera::where('is_active', true)->orderBy('name')->get();
        $batteries = Battery::where('is_active', true)->orderBy('capacity_mah')->get();

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
            'phone', 'brands', 'colors', 'storages', 'rams', 'screens', 'cameras', 'batteries',
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
            'ram_id' => 'required|exists:rams,id',
            'screen_id' => 'required|exists:screens,id',
            'camera_id' => 'required|exists:cameras,id',
            'battery_id' => 'required|exists:batteries,id',
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

        $storages = Storage::withCount('phones')->get();
        return view('admin.data.storages', compact('storages'));
    }


    public function rams()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $rams = Ram::withCount('phones')->get();
        return view('admin.data.rams', compact('rams'));
    }

    public function screens()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $screens = Screen::withCount('phones')->get();
        return view('admin.data.screens', compact('screens'));
    }

    public function cameras()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $cameras = Camera::withCount('phones')->get();
        return view('admin.data.cameras', compact('cameras'));
    }

    public function batteries()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $batteries = Battery::withCount('phones')->get();
        return view('admin.data.batteries', compact('batteries'));
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

        Storage::create($request->all());

        return redirect()->route('admin.data.storages')->with('success', 'Depolama başarıyla eklendi!');
    }

    public function editStorage(Storage $storage)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.storages.edit', compact('storage'));
    }

    public function updateStorage(Request $request, Storage $storage)
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


    public function createRam()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.rams.create');
    }

    public function storeRam(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:rams',
            'capacity_gb' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        Ram::create($request->all());

        return redirect()->route('admin.data.rams')->with('success', 'RAM başarıyla eklendi!');
    }

    public function editRam(Ram $ram)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.rams.edit', compact('ram'));
    }

    public function updateRam(Request $request, Ram $ram)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:rams,name,' . $ram->id,
            'capacity_gb' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $ram->update($data);

        return redirect()->route('admin.data.rams')->with('success', 'RAM başarıyla güncellendi!');
    }

    public function createScreen()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.screens.create');
    }

    public function storeScreen(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:screens',
            'size_inches' => 'required|numeric|min:1|max:20',
            'resolution' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        Screen::create($request->all());

        return redirect()->route('admin.data.screens')->with('success', 'Ekran başarıyla eklendi!');
    }

    public function editScreen(Screen $screen)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.screens.edit', compact('screen'));
    }

    public function updateScreen(Request $request, Screen $screen)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:screens,name,' . $screen->id,
            'size_inches' => 'required|numeric|min:1|max:20',
            'resolution' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $screen->update($data);

        return redirect()->route('admin.data.screens')->with('success', 'Ekran başarıyla güncellendi!');
    }

    public function createCamera()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.cameras.create');
    }

    public function storeCamera(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:cameras',
            'specification' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        Camera::create($request->all());

        return redirect()->route('admin.data.cameras')->with('success', 'Kamera başarıyla eklendi!');
    }

    public function createBattery()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.batteries.create');
    }

    public function storeBattery(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:batteries',
            'capacity_mah' => 'required|integer|min:100',
            'is_active' => 'boolean'
        ]);

        Battery::create($request->all());

        return redirect()->route('admin.data.batteries')->with('success', 'Batarya başarıyla eklendi!');
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

    public function editCamera(Camera $camera)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.data.cameras.edit', compact('camera'));
    }

    public function updateCamera(Request $request, Camera $camera)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:cameras,name,' . $camera->id,
            'specification' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $camera->update($data);

        return redirect()->route('admin.data.cameras')->with('success', 'Kamera başarıyla güncellendi!');
    }
}
