@extends('layouts.admin')

@section('title', 'Telefon Düzenle - Admin Panel')
@section('page-title', 'Telefon Düzenle')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.phones.show', $phone) }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Telefon Detayına Dön
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Telefon Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">Stok Seri No: {{ $phone->stock_serial }}</p>
        </div>
        
        <form method="POST" action="{{ route('admin.phones.update', $phone) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-mobile-alt mr-2"></i>Telefon Adı *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $phone->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="iPhone 15 Pro Max"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2"></i>Marka *
                    </label>
                    <select id="brand_id" 
                            name="brand_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('brand_id') border-red-500 @enderror"
                            required>
                        <option value="">Marka Seçiniz</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $phone->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="phone_model_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-mobile-alt mr-2"></i>Model *
                    </label>
                    <select id="phone_model_id" 
                            name="phone_model_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_model_id') border-red-500 @enderror"
                            required>
                        <option value="">Model Seçiniz</option>
                        @foreach($phoneModels as $model)
                            <option value="{{ $model->id }}" {{ old('phone_model_id', $phone->phone_model_id) == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('phone_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-palette mr-2"></i>Renk *
                    </label>
                    <select id="color_id" 
                            name="color_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('color_id') border-red-500 @enderror"
                            required>
                        <option value="">Renk Seçiniz</option>
                        @foreach($brandColors as $color)
                            <option value="{{ $color->id }}" {{ old('color_id', $phone->color_id) == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('color_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Technical Specifications -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Storage -->
                <div>
                    <label for="storage_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hdd mr-2"></i>Depolama *
                    </label>
                    <select id="storage_id" 
                            name="storage_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('storage_id') border-red-500 @enderror"
                            required>
                        <option value="">Depolama Seçiniz</option>
                        @foreach($storages as $storage)
                            <option value="{{ $storage->id }}" {{ old('storage_id', $phone->storage_id) == $storage->id ? 'selected' : '' }}>
                                {{ $storage->name }} ({{ $storage->capacity_gb }}GB)
                            </option>
                        @endforeach
                    </select>
                    @error('storage_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RAM -->
                <div>
                    <label for="ram_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-microchip mr-2"></i>RAM *
                    </label>
                    <select id="ram_id" 
                            name="ram_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ram_id') border-red-500 @enderror"
                            required>
                        <option value="">RAM Seçiniz</option>
                        @foreach($rams as $ram)
                            <option value="{{ $ram->id }}" {{ old('ram_id', $phone->ram_id) == $ram->id ? 'selected' : '' }}>
                                {{ $ram->name }} ({{ $ram->capacity_gb }}GB)
                            </option>
                        @endforeach
                    </select>
                    @error('ram_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Screen Size -->
                <div>
                    <label for="screen_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-mobile-alt mr-2"></i>Ekran Boyutu *
                    </label>
                    <select id="screen_id" 
                            name="screen_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('screen_id') border-red-500 @enderror"
                            required>
                        <option value="">Ekran Boyutu Seçiniz</option>
                        @foreach($screens as $screen)
                            <option value="{{ $screen->id }}" {{ old('screen_id', $phone->screen_id) == $screen->id ? 'selected' : '' }}>
                                {{ $screen->name }} ({{ $screen->resolution }})
                            </option>
                        @endforeach
                    </select>
                    @error('screen_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Camera -->
                <div>
                    <label for="camera_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera mr-2"></i>Kamera *
                    </label>
                    <select id="camera_id" 
                            name="camera_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('camera_id') border-red-500 @enderror"
                            required>
                        <option value="">Kamera Seçiniz</option>
                        @foreach($cameras as $camera)
                            <option value="{{ $camera->id }}" {{ old('camera_id', $phone->camera_id) == $camera->id ? 'selected' : '' }}>
                                {{ $camera->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('camera_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Battery -->
                <div>
                    <label for="battery_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-battery-three-quarters mr-2"></i>Batarya *
                    </label>
                    <select id="battery_id" 
                            name="battery_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('battery_id') border-red-500 @enderror"
                            required>
                        <option value="">Batarya Seçiniz</option>
                        @foreach($batteries as $battery)
                            <option value="{{ $battery->id }}" {{ old('battery_id', $phone->battery_id) == $battery->id ? 'selected' : '' }}>
                                {{ $battery->name }} ({{ $battery->capacity_mah }}mAh)
                            </option>
                        @endforeach
                    </select>
                    @error('battery_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <!-- Stock Serial -->
                <div>
                    <label for="stock_serial" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-2"></i>Stok Seri No *
                    </label>
                    <input type="text" 
                           id="stock_serial" 
                           name="stock_serial" 
                           value="{{ old('stock_serial', $phone->stock_serial) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_serial') border-red-500 @enderror"
                           placeholder="MT001234"
                           required>
                    @error('stock_serial')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2"></i>Açıklama (Bu alan Web sitesinde görünecektir. Boş Bırakılabilir)
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Telefon hakkında detaylı açıklama...">{{ old('description', $phone->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Notlar (Sadece Admin için)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                          placeholder="Telefon hakkında özel notlar...">{{ old('notes', $phone->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Purchase Price -->
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shopping-cart mr-2"></i>Alış Fiyatı (₺) *
                    </label>
                    <input type="number" 
                           id="purchase_price" 
                           name="purchase_price" 
                           value="{{ old('purchase_price', $phone->purchase_price) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('purchase_price') border-red-500 @enderror"
                           placeholder="50000"
                           min="0"
                           step="0.01"
                           required>
                    @error('purchase_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2"></i>Satış Fiyatı (₺)
                    </label>
                    <input type="number" 
                           id="sale_price" 
                           name="sale_price" 
                           value="{{ old('sale_price', $phone->sale_price) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sale_price') border-red-500 @enderror"
                           placeholder="55000"
                           min="0"
                           step="0.01">
                    @error('sale_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status and Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-certificate mr-2"></i>Durum *
                    </label>
                    <select id="condition" 
                            name="condition" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('condition') border-red-500 @enderror"
                            required>
                        <option value="">Durum Seçiniz</option>
                        <option value="sifir" {{ old('condition', $phone->condition) == 'sifir' ? 'selected' : '' }}>Sıfır</option>
                        <option value="ikinci_el" {{ old('condition', $phone->condition) == 'ikinci_el' ? 'selected' : '' }}>İkinci El</option>
                    </select>
                    @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Origin -->
                <div>
                    <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-globe mr-2"></i>Menşei *
                    </label>
                    <select id="origin" 
                            name="origin" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('origin') border-red-500 @enderror"
                            required>
                        <option value="">Menşei Seçiniz</option>
                        <option value="turkiye" {{ old('origin', $phone->origin) == 'turkiye' ? 'selected' : '' }}>Türkiye</option>
                        <option value="yurtdisi" {{ old('origin', $phone->origin) == 'yurtdisi' ? 'selected' : '' }}>Yurtdışı</option>
                    </select>
                    @error('origin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sale Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sale Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shopping-cart mr-2"></i>Satış Durumu
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_sold" 
                                   value="1"
                                   {{ old('is_sold', $phone->is_sold) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Satıldı</span>
                        </label>
                        @if($phone->sold_at)
                            <div class="text-sm text-gray-600">
                                Satış Tarihi: {{ $phone->sold_at->format('d.m.Y H:i') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Featured -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-star mr-2"></i>Öne Çıkan
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1"
                               {{ old('is_featured', $phone->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Öne çıkan telefon olarak işaretle</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.phones.show', $phone) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Güncelle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand_id');
    const modelSelect = document.getElementById('phone_model_id');
    const colorSelect = document.getElementById('color_id');
    
    // Mevcut değerleri sakla
    const currentModelId = '{{ $phone->phone_model_id }}';
    const currentColorId = '{{ $phone->color_id }}';
    
    // Marka değiştiğinde modelleri ve renkleri güncelle
    brandSelect.addEventListener('change', function() {
        const brandId = this.value;
        
        // Model yükleme
        modelSelect.innerHTML = '<option value="">Yükleniyor...</option>';
        modelSelect.disabled = true;
        
        // Renk yükleme
        colorSelect.innerHTML = '<option value="">Yükleniyor...</option>';
        colorSelect.disabled = true;
        
        if (brandId) {
            // Model yükleme
            fetch(`{{ route('admin.phones.models-by-brand') }}?brand_id=${brandId}`)
                .then(response => response.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Model Seçiniz</option>';
                    
                    if (data.models && data.models.length > 0) {
                        data.models.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            if (model.id == currentModelId) {
                                option.selected = true;
                            }
                            modelSelect.appendChild(option);
                        });
                        modelSelect.disabled = false;
                    } else {
                        modelSelect.innerHTML = '<option value="">Bu markaya ait model bulunamadı</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modelSelect.innerHTML = '<option value="">Hata oluştu</option>';
                });
            
            // Renk yükleme
            fetch(`{{ route('admin.phones.colors-by-brand') }}?brand_id=${brandId}`)
                .then(response => response.json())
                .then(data => {
                    colorSelect.innerHTML = '<option value="">Renk Seçiniz</option>';
                    
                    if (data.colors && data.colors.length > 0) {
                        data.colors.forEach(color => {
                            const option = document.createElement('option');
                            option.value = color.id;
                            option.textContent = color.name;
                            if (color.id == currentColorId) {
                                option.selected = true;
                            }
                            colorSelect.appendChild(option);
                        });
                        colorSelect.disabled = false;
                    } else {
                        colorSelect.innerHTML = '<option value="">Bu markaya ait renk bulunamadı</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    colorSelect.innerHTML = '<option value="">Hata oluştu</option>';
                });
        } else {
            modelSelect.innerHTML = '<option value="">Önce marka seçiniz</option>';
            colorSelect.innerHTML = '<option value="">Önce marka seçiniz</option>';
        }
    });
});
</script>
@endsection
