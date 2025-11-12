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
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\CustomerRecord;
use App\Models\Admin;
use App\Models\AuditLog;
use App\Helpers\AuditHelper;
use Illuminate\Support\Facades\Hash;

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

        // Veritabanından admin bul
        $admin = Admin::where('email', $credentials['email'])->first();

        // Admin kontrolü
        if (!$admin) {
            return back()->withErrors([
                'email' => 'Giriş bilgileri hatalı.',
            ]);
        }

        // Aktif kontrolü
        if (!$admin->is_active) {
            return back()->withErrors([
                'email' => 'Hesabınız devre dışı bırakılmış.',
            ]);
        }

        // Şifre kontrolü
        if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors([
                'email' => 'Giriş bilgileri hatalı.',
            ]);
        }

        // Login başarılı - session'a kaydet
        session([
            'admin_logged_in' => true,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_role' => $admin->role
        ]);

        // Son giriş bilgilerini güncelle
        $admin->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);

        // Audit log
        AuditHelper::logLogin($admin);

        return redirect()->route('admin.dashboard');
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

    public function sales(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Get all customer records (sales) with phone and customer info
        $customerRecordsQuery = CustomerRecord::with(['phone.brand', 'phone.phoneModel', 'phone.storage', 'customer']);

        // Get phones that are sold but don't have CustomerRecord (old sales)
        $phonesWithoutRecordQuery = Phone::with(['brand', 'phoneModel', 'storage'])
            ->where('is_sold', true)
            ->whereDoesntHave('customerRecords');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            
            // Search in CustomerRecords
            $customerRecordsQuery->where(function($q) use ($searchTerm) {
                $q->whereHas('phone', function($phoneQuery) use ($searchTerm) {
                    $phoneQuery->where('name', 'LIKE', "%{$searchTerm}%")
                               ->orWhere('stock_serial', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('customer', function($customerQuery) use ($searchTerm) {
                    $searchParts = preg_split('/\s+/', trim($searchTerm));
                    
                    if (count($searchParts) > 1) {
                        $firstName = $searchParts[0];
                        $lastName = implode(' ', array_slice($searchParts, 1));
                        
                        $customerQuery->where(function($subQ) use ($firstName, $lastName) {
                            $subQ->where('name', 'LIKE', "%{$firstName}%")
                                 ->where('surname', 'LIKE', "%{$lastName}%");
                        })
                        ->orWhereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$searchTerm}%"])
                        ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('surname', 'LIKE', "%{$searchTerm}%");
                    } else {
                        $customerQuery->where('name', 'LIKE', "%{$searchTerm}%")
                                     ->orWhere('surname', 'LIKE', "%{$searchTerm}%")
                                     ->orWhereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$searchTerm}%"]);
                    }
                });
            });

            // Search in Phones without CustomerRecord
            $phonesWithoutRecordQuery->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('stock_serial', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Date filter for CustomerRecords
        if ($request->filled('date_filter')) {
            $dateFilter = $request->get('date_filter');
            switch ($dateFilter) {
                case 'today':
                    $customerRecordsQuery->whereDate('created_at', today());
                    $phonesWithoutRecordQuery->whereDate('sold_at', today());
                    break;
                case 'yesterday':
                    $customerRecordsQuery->whereDate('created_at', today()->subDay());
                    $phonesWithoutRecordQuery->whereDate('sold_at', today()->subDay());
                    break;
                case 'this_week':
                    $customerRecordsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    $phonesWithoutRecordQuery->whereBetween('sold_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $customerRecordsQuery->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    $phonesWithoutRecordQuery->whereMonth('sold_at', now()->month)
                          ->whereYear('sold_at', now()->year);
                    break;
                case 'last_month':
                    $customerRecordsQuery->whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year);
                    $phonesWithoutRecordQuery->whereMonth('sold_at', now()->subMonth()->month)
                          ->whereYear('sold_at', now()->subMonth()->year);
                    break;
            }
        }

        $customerRecords = $customerRecordsQuery->orderBy('created_at', 'desc')->get();
        $phonesWithoutRecord = $phonesWithoutRecordQuery->orderBy('sold_at', 'desc')->get();

        // Combine and convert phones without record to a format similar to CustomerRecord
        $allSales = collect();
        
        // Add CustomerRecords
        foreach ($customerRecords as $record) {
            $allSales->push((object)[
                'id' => 'cr_' . $record->id,
                'type' => 'customer_record',
                'customer_record' => $record,
                'phone' => $record->phone,
                'customer' => $record->customer,
                'sale_price' => $record->sale_price,
                'paid_amount' => $record->paid_amount,
                'remaining_debt' => $record->remaining_debt,
                'payment_status' => $record->payment_status,
                'created_at' => $record->created_at,
                'sold_at' => $record->created_at
            ]);
        }

        // Add Phones without CustomerRecord
        foreach ($phonesWithoutRecord as $phone) {
            $allSales->push((object)[
                'id' => 'phone_' . $phone->id,
                'type' => 'phone_only',
                'customer_record' => null,
                'phone' => $phone,
                'customer' => null,
                'sale_price' => $phone->sale_price ?? 0,
                'paid_amount' => $phone->sale_price ?? 0, // Assume fully paid for old sales
                'remaining_debt' => 0,
                'payment_status' => 'paid',
                'created_at' => $phone->sold_at ?? $phone->created_at,
                'sold_at' => $phone->sold_at ?? $phone->created_at
            ]);
        }

        // Sort by sale date (newest first)
        $allSales = $allSales->sortByDesc(function($sale) {
            return $sale->sold_at ? $sale->sold_at->timestamp : 0;
        })->values();

        // Group sales by date
        $groupedSales = $allSales->groupBy(function($sale) {
            return $sale->sold_at ? $sale->sold_at->format('Y-m-d') : $sale->created_at->format('Y-m-d');
        });

        // Calculate totals
        $totalSales = $allSales->count();
        $totalRevenue = $allSales->sum(function($sale) {
            $phone = $sale->phone;
            $purchasePrice = $phone ? ($phone->purchase_price ?? 0) : 0;
            return $purchasePrice > 0 ? $sale->sale_price - $purchasePrice : $sale->sale_price;
        });
        $totalPaid = $allSales->sum('paid_amount');
        $totalDebt = $allSales->sum('remaining_debt');

        return view('admin.sales.index', compact('groupedSales', 'totalSales', 'totalRevenue', 'totalPaid', 'totalDebt'));
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

        // Marka filtresi
        if ($request->filled('brand_filter')) {
            $query->where('brand_id', $request->get('brand_filter'));
        }

        // Durum filtresi
        if ($request->filled('condition_filter')) {
            $query->where('condition', $request->get('condition_filter'));
        }

        // Öne çıkan filtresi
        if ($request->filled('featured_filter')) {
            $query->where('is_featured', $request->get('featured_filter'));
        }

        $phones = $query->orderBy('created_at', 'desc')->paginate(25)->appends(request()->query());

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
        $adminId = session('admin_id');
        if ($adminId) {
            $admin = Admin::find($adminId);
            if ($admin) {
                AuditHelper::logLogout($admin);
            }
        }

        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_role']);
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
            'customer_info' => 'nullable|string',
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
            $phone = Phone::create($phoneData);
            AuditHelper::logCreate($phone);
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
            'customer_info' => 'nullable|string',
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

        $oldValues = $phone->toArray();
        $phone->update($phoneData);
        AuditHelper::logUpdate($phone, $oldValues);

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
            AuditHelper::logDelete($phone, $phoneName . ' telefonu silindi');
            
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

        try {
            // Debug: Log the incoming request data
            Log::info('Sale request data:', $request->all());
            
            // Start database transaction
            \DB::beginTransaction();
            
            $validationRules = [
                'serial_number' => 'required|string',
                'sale_price' => 'required|numeric|min:0',
                'sale_note' => 'nullable|string|max:1000',
                'sale_date' => 'nullable|date',
                'add_to_customers' => 'nullable|boolean',
                'customer_id' => 'nullable|exists:customers,id',
                'customer_name' => 'nullable|string|max:255',
                'customer_surname' => 'nullable|string|max:255',
                'customer_phone' => 'nullable|string|max:20',
                'payment_option' => 'required|in:full,partial'
            ];
            
            // Add conditional validation for customer fields
            if ($request->add_to_customers && !$request->customer_id) {
                $validationRules['customer_name'] = 'required|string|max:255';
                $validationRules['customer_surname'] = 'required|string|max:255';
            }
            
            // Only validate partial_amount if payment_option is partial
            if ($request->payment_option === 'partial') {
                $validationRules['partial_amount'] = 'required|numeric|min:0.01';
            }
            
            $request->validate($validationRules);

        $phone = Phone::with(['brand', 'phoneModel', 'storage'])->where('stock_serial', $request->serial_number)->first();

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

        // Handle customer selection/creation
        $customer = null;
        $addToCustomers = filter_var($request->add_to_customers, FILTER_VALIDATE_BOOLEAN);
        
        if ($addToCustomers) {
            // Check if existing customer is selected
            if ($request->customer_id) {
                $customer = Customer::find($request->customer_id);
            } else {
                // Check if customer already exists by name and surname
                $existingCustomer = Customer::where('name', $request->customer_name)
                    ->where('surname', $request->customer_surname)
                    ->first();
                
                if ($existingCustomer) {
                    $customer = $existingCustomer;
                } else {
                    // Create new customer
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'surname' => $request->customer_surname,
                        'phone' => $request->customer_phone,
                        'debt' => 0, // Will be calculated from records
                        'notes' => 'Müşteri kaydı'
                    ]);
                }
            }
        }

        // Calculate payment and debt
        $salePrice = floatval($request->sale_price);
        $paymentAmount = $request->payment_option === 'partial' ? floatval($request->partial_amount) : $salePrice;
        $remainingDebt = max(0, $salePrice - $paymentAmount); // Ensure remaining_debt is never negative

		// Create customer record (even if customer is not selected) to track payments/debt
		$paymentStatus = 'paid';
		if ($remainingDebt > 0.01) { // Use small threshold for floating point comparison
			$paymentStatus = $paymentAmount > 0 ? 'partial' : 'pending';
		} else {
			// If remaining debt is 0 or very close to 0, mark as paid
			$remainingDebt = 0;
			$paymentStatus = 'paid';
		}
		
		// Determine sale date - use provided date or current date
		$saleDate = $request->filled('sale_date') 
			? \Carbon\Carbon::parse($request->sale_date) 
			: now();
		
		$customerRecord = CustomerRecord::create([
			'customer_id' => $customer ? $customer->id : null,
			'phone_id' => $phone->id,
			'sale_price' => $salePrice,
			'paid_amount' => $paymentAmount,
			'remaining_debt' => round($remainingDebt, 2), // Round to 2 decimal places
			'payment_status' => $paymentStatus,
			'notes' => $request->sale_note,
			'created_at' => $saleDate, // Set custom sale date
			'updated_at' => $saleDate
		]);
		
		// Update customer total debt and create payment record only when a customer exists
		if ($customer) {
			$customer->update(['debt' => $customer->total_debt]);
			if ($paymentAmount > 0) {
				CustomerPayment::create([
					'customer_id' => $customer->id,
					'amount' => $paymentAmount,
					'previous_debt' => $salePrice,
					'remaining_debt' => $remainingDebt,
					'payment_method' => 'cash',
					'notes' => 'Telefon satışı - ' . $this->getDeviceInfo($phone)
				]);
			}
		}

        // Update phone as sold
        $updateData = [
            'is_sold' => true,
            'sale_price' => $salePrice,
            'sold_at' => $saleDate // Use custom sale date or current date
        ];
        
		// Add sale note if provided (append to existing notes instead of overwriting)
		if ($request->filled('sale_note')) {
			$existingNotes = trim((string) $phone->notes);
			$newNote = trim($request->sale_note);
			$updateData['notes'] = $existingNotes !== ''
				? $existingNotes . "\n" . $newNote
				: $newNote;
		}
        
        $phone->update($updateData);
        $phone->refresh(); // Ensure we have the latest data
        
        // Debug: Log the phone update
        Log::info('Phone updated after sale:', [
            'phone_id' => $phone->id,
            'phone_name' => $phone->name,
            'is_sold' => $phone->is_sold,
            'sale_price' => $phone->sale_price,
            'update_data' => $updateData
        ]);

        // Prepare success message
        $message = "{$phone->name} cihazı başarıyla satıldı. Satış fiyatı: " . number_format($salePrice, 2) . " ₺";
        
        if ($customer) {
            $message .= " - Müşteri: {$customer->full_name}";
            if ($remainingDebt > 0) {
                $message .= " - Kalan borç: " . number_format($remainingDebt, 2) . " ₺";
            }
        }

        // Commit transaction
        \DB::commit();

        // Audit log
        AuditHelper::logSale($phone, $salePrice, $customer);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
        
        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::rollback();
            Log::error('Sale error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Satış işlemi sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function repurchasePhone(Request $request)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            \DB::beginTransaction();
            
            $request->validate([
                'phone_id' => 'required|exists:phones,id',
                'repurchase_price' => 'required|numeric|min:0',
                'repurchase_note' => 'nullable|string|max:1000'
            ]);

            $phone = Phone::with(['brand', 'phoneModel', 'storage'])->find($request->phone_id);

            if (!$phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cihaz bulunamadı'
                ]);
            }

            if (!$phone->is_sold) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu cihaz satılmamış, geri alınamaz'
                ]);
            }

            // Get the customer record for this sale
            $customerRecord = $phone->customerRecords()->where('phone_id', $phone->id)->first();
            
            // Update phone - mark as not sold and add repurchase info
            $updateData = [
                'is_sold' => false,
                'repurchased_at' => now(),
                'repurchase_price' => $request->repurchase_price,
                'sale_price' => null, // Clear sale price
                'sold_at' => null // Clear sold_at
            ];
            
            // Add repurchase note if provided
            if ($request->filled('repurchase_note')) {
                $existingNotes = trim((string) $phone->notes);
                $newNote = trim($request->repurchase_note);
                $updateData['notes'] = $existingNotes !== ''
                    ? $existingNotes . "\n[Geri Alındı: " . now()->format('d.m.Y H:i') . "] " . $newNote
                    : "[Geri Alındı: " . now()->format('d.m.Y H:i') . "] " . $newNote;
            } else {
                $existingNotes = trim((string) $phone->notes);
                $updateData['notes'] = $existingNotes !== ''
                    ? $existingNotes . "\n[Geri Alındı: " . now()->format('d.m.Y H:i') . "]"
                    : "[Geri Alındı: " . now()->format('d.m.Y H:i') . "]";
            }
            
            $phone->update($updateData);
            
            // If there's a customer record with remaining debt, we might want to handle it
            // For now, we'll keep the customer record for history but mark it appropriately
            // The customer's debt will be recalculated automatically via the total_debt accessor
            
            \DB::commit();

            // Audit log
            AuditHelper::logRepurchase($phone, $request->repurchase_price);

            return response()->json([
                'success' => true,
                'message' => "{$phone->name} cihazı başarıyla geri alındı. Geri alma fiyatı: " . number_format($request->repurchase_price, 2) . " ₺"
            ]);
            
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('Repurchase error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Geri alma işlemi sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSale(Request $request, $saleId)
    {
        if (!session('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            return redirect()->route('admin.login');
        }

        try {
            \DB::beginTransaction();

            // Parse sale ID to determine type
            if (strpos($saleId, 'cr_') === 0) {
                // CustomerRecord type
                $recordId = (int) str_replace('cr_', '', $saleId);
                $customerRecord = CustomerRecord::with(['phone', 'customer'])->find($recordId);

                if (!$customerRecord) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Satış kaydı bulunamadı'
                        ], 404);
                    }
                    return redirect()->back()->with('error', 'Satış kaydı bulunamadı');
                }

                $phone = $customerRecord->phone;
                $customer = $customerRecord->customer;

                // Delete CustomerRecord
                $customerRecord->delete();

                // Update phone - mark as not sold
                if ($phone) {
                    $phone->update([
                        'is_sold' => false,
                        'sold_at' => null,
                        'sale_price' => null
                    ]);
                }

                // Update customer debt if customer exists (but don't delete customer)
                if ($customer) {
                    $customer->update(['debt' => $customer->total_debt]);
                }

                // Audit log
                if ($phone) {
                    AuditHelper::logDelete($phone, "Satış kaydı silindi - {$phone->name}");
                }

                \DB::commit();

                $message = "Satış kaydı başarıyla silindi.";
                if ($phone) {
                    $message .= " Cihaz: {$phone->name}";
                }

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $message
                    ]);
                }

                return redirect()->route('admin.sales.index')->with('success', $message);

            } elseif (strpos($saleId, 'phone_') === 0) {
                // Phone only type (old sales without CustomerRecord)
                $phoneId = (int) str_replace('phone_', '', $saleId);
                $phone = Phone::find($phoneId);

                if (!$phone) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cihaz bulunamadı'
                        ], 404);
                    }
                    return redirect()->back()->with('error', 'Cihaz bulunamadı');
                }

                // Update phone - mark as not sold
                $phone->update([
                    'is_sold' => false,
                    'sold_at' => null,
                    'sale_price' => null
                ]);

                // Audit log
                AuditHelper::logDelete($phone, "Eski satış kaydı silindi - {$phone->name}");

                \DB::commit();

                $message = "Satış kaydı başarıyla silindi. Cihaz: {$phone->name}";

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $message
                    ]);
                }

                return redirect()->route('admin.sales.index')->with('success', $message);
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Geçersiz satış ID formatı'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Geçersiz satış ID formatı');
            }

        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('Delete sale error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Satış kaydı silinirken bir hata oluştu: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Satış kaydı silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    // Helper function to get device information
    private function getDeviceInfo($phone)
    {
        $deviceInfo = $phone->name;
        
        if ($phone->brand && $phone->phoneModel) {
            $deviceInfo = $phone->brand->name . ' ' . $phone->phoneModel->name;
        } elseif ($phone->brand) {
            $deviceInfo = $phone->brand->name . ' ' . $deviceInfo;
        }
        
        if ($phone->storage) {
            $deviceInfo .= ' ' . $phone->storage->name;
        }
        
        return $deviceInfo;
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

    // Admin Management
    public function admins(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        $query = Admin::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role_filter')) {
            $query->where('role', $request->role_filter);
        }

        // Status filter
        if ($request->filled('status_filter')) {
            $query->where('is_active', $request->status_filter === 'active');
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function createAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        return view('admin.admins.create');
    }

    public function storeAdmin(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,manager,staff',
            'permissions' => 'nullable|array',
            'is_active' => 'nullable|boolean'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'permissions' => $request->permissions ?? [],
            'is_active' => $request->has('is_active') ? true : false
        ]);

        AuditHelper::logCreate($admin, $admin->name . ' admin kullanıcısı oluşturuldu');

        return redirect()->route('admin.admins.index')->with('success', 'Admin kullanıcısı başarıyla oluşturuldu.');
    }

    public function editAdmin(Admin $admin)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    public function updateAdmin(Request $request, Admin $admin)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,manager,staff',
            'permissions' => 'nullable|array',
            'is_active' => 'nullable|boolean'
        ]);

        $oldValues = $admin->toArray();
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'permissions' => $request->permissions ?? [],
            'is_active' => $request->has('is_active') ? true : false
        ];

        if ($request->filled('password')) {
            $updateData['password'] = $request->password;
        }

        $admin->update($updateData);

        AuditHelper::logUpdate($admin, $oldValues, $admin->name . ' admin kullanıcısı güncellendi');

        return redirect()->route('admin.admins.index')->with('success', 'Admin kullanıcısı başarıyla güncellendi.');
    }

    public function destroyAdmin(Admin $admin)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        // Kendi hesabını silemez
        if ($admin->id === $currentAdmin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'Kendi hesabınızı silemezsiniz.');
        }

        $adminName = $admin->name;
        $admin->delete();

        AuditHelper::logDelete($admin, $adminName . ' admin kullanıcısı silindi');

        return redirect()->route('admin.admins.index')->with('success', 'Admin kullanıcısı başarıyla silindi.');
    }

    // Audit Logs
    public function auditLogs(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $currentAdmin = Admin::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Bu işlem için yetkiniz yok.');
        }

        $query = AuditLog::with('admin')->orderBy('created_at', 'desc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('admin', function($adminQuery) use ($search) {
                      $adminQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Action filter
        if ($request->filled('action_filter')) {
            $query->where('action', $request->action_filter);
        }

        // Date filter
        if ($request->filled('date_filter')) {
            $dateFilter = $request->get('date_filter');
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        $logs = $query->paginate(50);

        return view('admin.audit-logs.index', compact('logs'));
    }
}
