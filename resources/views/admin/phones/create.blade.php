@extends('layouts.admin')

@section('title', 'Yeni Telefon Ekle - Admin Panel')
@section('page-title', 'Yeni Telefon Ekle')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Telefon Bilgileri</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.phones.store') }}" class="p-6 space-y-6">
            @csrf
            
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
                           value="{{ old('name') }}"
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
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                        <i class="fas fa-cube mr-2"></i>Model *
                    </label>
                    <select id="phone_model_id" 
                            name="phone_model_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_model_id') border-red-500 @enderror"
                            required
                            disabled>
                        <option value="">Önce marka seçiniz</option>
                    </select>
                    @error('phone_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="color_id" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-palette mr-2"></i>Renk
                        </label>
                        <button type="button" 
                                id="color-filter-btn" 
                                class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition duration-200"
                                disabled>
                            <i class="fas fa-filter mr-1"></i>Filtrele
                        </button>
                    </div>
                    <select id="color_id" 
                            name="color_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('color_id') border-red-500 @enderror">
                        <option value="">Renk Seçiniz</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('color_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price and Condition -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Purchase Price -->
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lira-sign mr-2"></i>Alış Fiyat (₺) *
                    </label>
                    <input type="number" 
                           id="purchase_price" 
                           name="purchase_price" 
                           value="{{ old('purchase_price') }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('purchase_price') border-red-500 @enderror"
                           placeholder="89999.00"
                           required>
                    @error('purchase_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2"></i>Satış Fiyat (₺)
                    </label>
                    <input type="number" 
                           id="sale_price" 
                           name="sale_price" 
                           value="{{ old('sale_price') }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sale_price') border-red-500 @enderror"
                           placeholder="99999.00">
                    @error('sale_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-certificate mr-2"></i>Durum *
                    </label>
                    <select id="condition" 
                            name="condition" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('condition') border-red-500 @enderror"
                            required>
                        <option value="">Seçiniz</option>
                        <option value="sifir" {{ old('condition') == 'sifir' ? 'selected' : '' }}>Sıfır</option>
                        <option value="ikinci_el" {{ old('condition') == 'ikinci_el' ? 'selected' : '' }}>İkinci El</option>
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
                        <option value="">Seçiniz</option>
                        <option value="turkiye" {{ old('origin') == 'turkiye' ? 'selected' : '' }}>Türkiye</option>
                        <option value="yurtdisi" {{ old('origin') == 'yurtdisi' ? 'selected' : '' }}>Yurtdışı</option>
                    </select>
                    @error('origin')
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
                            <option value="{{ $storage->id }}" {{ old('storage_id') == $storage->id ? 'selected' : '' }}>
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
                            <option value="{{ $ram->id }}" {{ old('ram_id') == $ram->id ? 'selected' : '' }}>
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
                        <i class="fas fa-mobile-alt mr-2"></i>Ekran Boyutu
                    </label>
                    <select id="screen_id" 
                            name="screen_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('screen_id') border-red-500 @enderror">
                        <option value="">Ekran Boyutu Seçiniz</option>
                        @foreach($screens as $screen)
                            <option value="{{ $screen->id }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
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
                        <i class="fas fa-camera mr-2"></i>Kamera
                    </label>
                    <select id="camera_id" 
                            name="camera_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('camera_id') border-red-500 @enderror">
                        <option value="">Kamera Seçiniz</option>
                        @foreach($cameras as $camera)
                            <option value="{{ $camera->id }}" {{ old('camera_id') == $camera->id ? 'selected' : '' }}>
                                {{ $camera->name }} - {{ $camera->specification }}
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
                        <i class="fas fa-battery-full mr-2"></i>Batarya *
                    </label>
                    <select id="battery_id" 
                            name="battery_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('battery_id') border-red-500 @enderror"
                            required>
                        <option value="">Batarya Seçiniz</option>
                        @foreach($batteries as $battery)
                            <option value="{{ $battery->id }}" {{ old('battery_id') == $battery->id ? 'selected' : '' }}>
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
                <!-- Stock Serial Numbers -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-2"></i>Stok Seri Numaraları
                    </label>
                    
                    <!-- Seri No Ekleme Alanı -->
                    <div class="flex gap-2 mb-3">
                        <input type="text" 
                               id="new_serial_input" 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="MT001234">
                        <button type="button" 
                                id="add_serial_btn"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i>Ekle
                        </button>
                    </div>
                    
                    <!-- Eklenen Seri Numaraları Listesi -->
                    <div id="serial_numbers_list" class="space-y-2 mb-3">
                        <!-- Dinamik olarak eklenecek -->
                    </div>
                    
                    <!-- Hidden input for form submission -->
                    <input type="hidden" id="stock_serials_hidden" name="stock_serials" value="">
                    
                    @error('stock_serials')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('stock_serials.*')
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
                          placeholder="Telefon hakkında detaylı açıklama...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Notlar (Bu alan sadece admin panelinde görünecektir)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                          placeholder="Ekran Kırık , Kasa çizik , Pil bozuk gibi notlar...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-images mr-2"></i>Resim URL'leri
                </label>
                <div id="image-inputs">
                    <div class="flex items-center space-x-2 mb-2">
                        <input type="text" 
                               name="images[]" 
                               value="{{ old('images.0') }}"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="https://example.com/image1.jpg">
                        <button type="button" onclick="removeImageInput(this)" class="text-red-500 hover:text-red-700" style="display: none;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addImageInput()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-plus mr-1"></i>Resim Ekle
                </button>
                <p class="text-sm text-gray-500 mt-1">Resim eklenmezse varsayılan telefon resmi kullanılacak.</p>
            </div>

            <!-- Featured -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_featured" 
                       name="is_featured" 
                       value="1"
                       {{ old('is_featured') ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_featured" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-star mr-1"></i>Öne çıkan telefon olarak işaretle
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Telefonu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addImageInput() {
        const container = document.getElementById('image-inputs');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mb-2';
        div.innerHTML = `
            <input type="text" 
                   name="images[]" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="https://example.com/image.jpg">
            <button type="button" onclick="removeImageInput(this)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
        updateRemoveButtons();
    }

    function removeImageInput(button) {
        button.parentElement.remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const container = document.getElementById('image-inputs');
        const inputs = container.querySelectorAll('div');
        
        inputs.forEach((div, index) => {
            const removeButton = div.querySelector('button');
            if (inputs.length === 1) {
                // Eğer sadece 1 input varsa silme butonunu gizle
                removeButton.style.display = 'none';
            } else {
                // Birden fazla input varsa silme butonunu göster
                removeButton.style.display = 'block';
            }
        });
    }

    // Sayfa yüklendiğinde butonları güncelle
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtons();
        
        // Marka seçimi değiştiğinde modelleri yükle
        const brandSelect = document.getElementById('brand_id');
        const modelSelect = document.getElementById('phone_model_id');
        const colorSelect = document.getElementById('color_id');
        const colorFilterBtn = document.getElementById('color-filter-btn');
        
        // Tüm renkleri sakla (filtreleme için)
        const allColors = Array.from(colorSelect.options).map(option => ({
            value: option.value,
            text: option.textContent
        }));
        
        let isFiltered = false;
        
        brandSelect.addEventListener('change', function() {
            const brandId = this.value;
            
            // Model seçimini temizle ve devre dışı bırak
            modelSelect.innerHTML = '<option value="">Yükleniyor...</option>';
            modelSelect.disabled = true;
            
            // Renk seçimini temizle ve devre dışı bırak
            colorSelect.innerHTML = '<option value="">Yükleniyor...</option>';
            colorSelect.disabled = true;
            
            // Renk filtresi butonunu güncelle
            if (brandId) {
                colorFilterBtn.disabled = false;
                colorFilterBtn.innerHTML = '<i class="fas fa-filter mr-1"></i>Filtrele';
                colorFilterBtn.className = 'text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition duration-200';
                isFiltered = false;
            } else {
                colorFilterBtn.disabled = true;
                colorFilterBtn.innerHTML = '<i class="fas fa-filter mr-1"></i>Filtrele';
                colorFilterBtn.className = 'text-xs bg-gray-100 text-gray-500 px-3 py-1 rounded-full';
                isFiltered = false;
            }
            
            if (brandId) {
                // AJAX ile modelleri getir
                fetch(`{{ route('admin.phones.models-by-brand') }}?brand_id=${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        modelSelect.innerHTML = '<option value="">Model Seçiniz</option>';
                        
                        if (data.models && data.models.length > 0) {
                            data.models.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.id;
                                option.textContent = model.name;
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
                
                // AJAX ile renkleri getir
                fetch(`{{ route('admin.phones.colors-by-brand') }}?brand_id=${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        colorSelect.innerHTML = '<option value="">Renk Seçiniz</option>';
                        
                        if (data.colors && data.colors.length > 0) {
                            data.colors.forEach(color => {
                                const option = document.createElement('option');
                                option.value = color.id;
                                option.textContent = color.name;
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
        
        // Renk filtresi butonu
        colorFilterBtn.addEventListener('click', function() {
            const brandId = brandSelect.value;
            
            if (!brandId) {
                alert('Önce marka seçiniz');
                return;
            }
            
            if (!isFiltered) {
                // Filtrele
                colorSelect.innerHTML = '<option value="">Yükleniyor...</option>';
                colorSelect.disabled = true;
                
                fetch(`{{ route('admin.phones.colors-by-brand') }}?brand_id=${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        colorSelect.innerHTML = '<option value="">Renk Seçiniz</option>';
                        
                        if (data.colors && data.colors.length > 0) {
                            data.colors.forEach(color => {
                                const option = document.createElement('option');
                                option.value = color.id;
                                option.textContent = color.name;
                                colorSelect.appendChild(option);
                            });
                            colorSelect.disabled = false;
                            
                            // Buton metnini güncelle
                            colorFilterBtn.innerHTML = '<i class="fas fa-undo mr-1"></i>Sıfırla';
                            colorFilterBtn.className = 'text-xs bg-orange-100 text-orange-700 px-3 py-1 rounded-full hover:bg-orange-200 transition duration-200';
                            isFiltered = true;
                        } else {
                            colorSelect.innerHTML = '<option value="">Bu markaya ait renk bulunamadı</option>';
                            colorSelect.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        colorSelect.innerHTML = '<option value="">Hata oluştu</option>';
                        colorSelect.disabled = false;
                    });
            } else {
                // Sıfırla - tüm renkleri geri yükle
                colorSelect.innerHTML = '';
                allColors.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.value;
                    option.textContent = color.text;
                    colorSelect.appendChild(option);
                });
                colorSelect.disabled = false;
                
                // Buton metnini güncelle
                colorFilterBtn.innerHTML = '<i class="fas fa-filter mr-1"></i>Filtrele';
                colorFilterBtn.className = 'text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition duration-200';
                isFiltered = false;
            }
        });
        
        // Seri numarası ekleme fonksiyonları
        const newSerialInput = document.getElementById('new_serial_input');
        const addSerialBtn = document.getElementById('add_serial_btn');
        const serialNumbersList = document.getElementById('serial_numbers_list');
        const stockSerialsHidden = document.getElementById('stock_serials_hidden');
        let serialNumbers = [];
        
        // Enter tuşu ile ekleme
        newSerialInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSerialNumber();
            }
        });
        
        // Ekle butonu ile ekleme
        addSerialBtn.addEventListener('click', function() {
            addSerialNumber();
        });
        
        function addSerialNumber() {
            const serialNumber = newSerialInput.value.trim();
            
            if (!serialNumber) {
                alert('Lütfen seri numarası giriniz');
                return;
            }
            
            if (serialNumbers.includes(serialNumber)) {
                alert('Bu seri numarası zaten eklenmiş');
                return;
            }
            
            // Seri numarasını listeye ekle
            serialNumbers.push(serialNumber);
            
            // UI'da göster
            const serialItem = document.createElement('div');
            serialItem.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border';
            serialItem.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-barcode text-gray-500 mr-2"></i>
                    <span class="font-mono text-sm">${serialNumber}</span>
                </div>
                <button type="button" 
                        class="text-red-500 hover:text-red-700 transition duration-200 remove-serial-btn"
                        data-serial="${serialNumber}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            serialNumbersList.appendChild(serialItem);
            
            // Input'u temizle
            newSerialInput.value = '';
            
            // Hidden input'u güncelle
            updateHiddenInput();
            
            // Kaldır butonuna event listener ekle
            serialItem.querySelector('.remove-serial-btn').addEventListener('click', function() {
                const serialToRemove = this.getAttribute('data-serial');
                removeSerialNumber(serialToRemove);
            });
        }
        
        function removeSerialNumber(serialNumber) {
            // Array'den kaldır
            serialNumbers = serialNumbers.filter(s => s !== serialNumber);
            
            // UI'dan kaldır
            const serialItems = serialNumbersList.querySelectorAll('.remove-serial-btn');
            serialItems.forEach(item => {
                if (item.getAttribute('data-serial') === serialNumber) {
                    item.closest('div').remove();
                }
            });
            
            // Hidden input'u güncelle
            updateHiddenInput();
        }
        
        function updateHiddenInput() {
            stockSerialsHidden.value = JSON.stringify(serialNumbers);
        }
        
        // Form gönderilmeden önce kontrol
        document.querySelector('form').addEventListener('submit', function(e) {
            if (serialNumbers.length === 0) {
                e.preventDefault();
                alert('En az bir seri numarası eklemelisiniz');
                return false;
            }
        });
    });
</script>
@endsection
