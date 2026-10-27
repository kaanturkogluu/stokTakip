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
        
        <form id="phone-create-form" method="POST" action="{{ route('admin.phones.store') }}" class="p-6 space-y-6">
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

            <!-- Zorunlu Teknik Özellikler -->
            <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-cogs mr-2"></i>Zorunlu Teknik Özellikler
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                </div>
            </div>

            <!-- Stok ve Opsiyonel Bilgiler -->
            <div class="border border-gray-200 rounded-lg p-6 bg-blue-50">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-barcode mr-2"></i>Stok Seri Numaraları ve Opsiyonel Özellikler
                </h3>
                
                <!-- Stock Serial Numbers -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-2"></i>Stok Seri Numaraları *
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
                    
                    <!-- Boş durum mesajı -->
                    <div id="empty_serials_message" class="text-gray-500 text-sm italic mb-3 p-3 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <i class="fas fa-info-circle mr-2"></i>Henüz seri numarası eklenmedi.
                    </div>
                    
                    <!-- Hidden input for form submission -->
                    <input type="hidden" id="stock_serials_hidden" name="stock_serials" value="{{ old('stock_serials', '') }}">
                    
                    @error('stock_serials')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('stock_serials.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Opsiyonel Özellikler -->
                <div class="border-t border-gray-300 pt-6">
                    <h4 class="text-md font-medium text-gray-800 mb-4">
                        <i class="fas fa-optional mr-2"></i>Opsiyonel Özellikler
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- No optional features for now -->
                    </div>
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

            <!-- Customer Info -->
            <div>
                <label for="customer_info" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2"></i>Müşteri Bilgileri
                </label>
                <textarea id="customer_info" 
                          name="customer_info" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_info') border-red-500 @enderror"
                          placeholder="Müşteri adı, telefon, adres gibi bilgiler...">{{ old('customer_info') }}</textarea>
                @error('customer_info')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-images mr-2"></i>Resim URL'leri
                </label>
                <div id="image-inputs">
                    @if(old('images') && count(old('images')) > 0)
                        @foreach(old('images') as $index => $image)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" 
                                       name="images[]" 
                                       value="{{ $image }}"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="https://example.com/image{{ $index + 1 }}.jpg">
                                <button type="button" onclick="removeImageInput(this)" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" 
                                   name="images[]" 
                                   value=""
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://example.com/image1.jpg">
                            <button type="button" onclick="removeImageInput(this)" class="text-red-500 hover:text-red-700" style="display: none;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
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
                        id="submit-phone-btn"
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
        if (!container) return;
        const inputs = container.querySelectorAll('div');
        inputs.forEach((div) => {
            const removeButton = div.querySelector('button');
            if (removeButton) {
                removeButton.style.display = (inputs.length === 1) ? 'none' : 'block';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let serialNumbers = [];
        updateRemoveButtons();

        // Eleman referansları
        const brandSelect = document.getElementById('brand_id');
        const modelSelect = document.getElementById('phone_model_id');
        const colorSelect = document.getElementById('color_id');
        const colorFilterBtn = document.getElementById('color-filter-btn');
        const newSerialInput = document.getElementById('new_serial_input');
        const addSerialBtn = document.getElementById('add_serial_btn');
        const serialNumbersList = document.getElementById('serial_numbers_list');
        const stockSerialsHidden = document.getElementById('stock_serials_hidden');
        const emptySerialsMessage = document.getElementById('empty_serials_message');
        const phoneForm = document.getElementById('phone-create-form');
        const submitBtn = document.getElementById('submit-phone-btn');

        // Tüm aktif sistem renkleri (anında hafızadan erişim)
        const allSystemColors = @json($colors);
        const initialBrandId = "{{ old('brand_id', '') }}";
        const initialModelId = "{{ old('phone_model_id', '') }}";
        const initialColorId = "{{ old('color_id', '') }}";

        let isBrandFiltered = false;
        let brandColorsCache = {};

        // Renkleri doldurma fonksiyonu
        function populateColors(colorList, selectedId, isBrandSpecific = false) {
            const currentSelected = selectedId || colorSelect.value;
            colorSelect.innerHTML = '<option value="">Renk Seçiniz</option>';

            if (colorList && colorList.length > 0) {
                colorList.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.id;
                    option.textContent = color.name;
                    if (currentSelected && String(color.id) === String(currentSelected)) {
                        option.selected = true;
                    }
                    colorSelect.appendChild(option);
                });
                colorSelect.disabled = false;
            } else {
                // Eğer markaya atanmış özel renk yoksa, kullanıcıyı tıkamamak için tüm renkleri listele
                allSystemColors.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.id;
                    option.textContent = color.name;
                    if (currentSelected && String(color.id) === String(currentSelected)) {
                        option.selected = true;
                    }
                    colorSelect.appendChild(option);
                });
                colorSelect.disabled = false;
                isBrandSpecific = false;
            }

            // Filtre butonunu güncelle
            if (colorFilterBtn) {
                if (isBrandSpecific) {
                    colorFilterBtn.innerHTML = '<i class="fas fa-list mr-1"></i>Tüm Renkler';
                    colorFilterBtn.className = 'text-xs bg-orange-100 text-orange-700 px-3 py-1 rounded-full hover:bg-orange-200 transition duration-200';
                    colorFilterBtn.title = 'Tüm renk seçeneklerini göster';
                    isBrandFiltered = true;
                } else {
                    colorFilterBtn.innerHTML = '<i class="fas fa-filter mr-1"></i>Marka Renkleri';
                    colorFilterBtn.className = 'text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition duration-200';
                    colorFilterBtn.title = 'Sadece seçili markaya ait renkleri göster';
                    isBrandFiltered = false;
                }
                colorFilterBtn.disabled = !brandSelect.value;
            }
        }

        // Marka renklerini getirme
        function loadBrandColors(brandId, selectedId) {
            if (!brandId) {
                populateColors(allSystemColors, selectedId, false);
                return;
            }

            if (brandColorsCache[brandId]) {
                if (brandColorsCache[brandId].length > 0) {
                    populateColors(brandColorsCache[brandId], selectedId, true);
                } else {
                    populateColors(allSystemColors, selectedId, false);
                }
                return;
            }

            // Sunucudan getir
            fetch(`{{ route('admin.phones.colors-by-brand') }}?brand_id=${brandId}`)
                .then(response => response.json())
                .then(data => {
                    brandColorsCache[brandId] = (data && data.colors) ? data.colors : [];
                    if (brandColorsCache[brandId].length > 0) {
                        populateColors(brandColorsCache[brandId], selectedId, true);
                    } else {
                        populateColors(allSystemColors, selectedId, false);
                    }
                })
                .catch(error => {
                    console.error('Renkler yüklenirken hata:', error);
                    populateColors(allSystemColors, selectedId, false);
                });
        }

        // Marka değiştiğinde modelleri ve renkleri güncelle
        brandSelect.addEventListener('change', function() {
            const brandId = this.value;
            modelSelect.innerHTML = '<option value="">Yükleniyor...</option>';
            modelSelect.disabled = true;

            if (brandId) {
                // Modelleri getir
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
                        console.error('Modeller yüklenirken hata:', error);
                        modelSelect.innerHTML = '<option value="">Hata oluştu</option>';
                    });

                // Renkleri yükle
                loadBrandColors(brandId, null);
            } else {
                modelSelect.innerHTML = '<option value="">Önce marka seçiniz</option>';
                modelSelect.disabled = true;
                populateColors(allSystemColors, null, false);
            }
        });

        // Renk filtreleme butonu (Marka Renkleri <-> Tüm Renkler anında geçiş)
        if (colorFilterBtn) {
            colorFilterBtn.addEventListener('click', function() {
                const brandId = brandSelect.value;
                const currentVal = colorSelect.value;
                if (!brandId) return;

                if (isBrandFiltered) {
                    // Marka renklerindeyken -> Tüm renklere geç
                    populateColors(allSystemColors, currentVal, false);
                } else {
                    // Tüm renklerindeyken -> Marka renklerine geç
                    if (brandColorsCache[brandId] && brandColorsCache[brandId].length > 0) {
                        populateColors(brandColorsCache[brandId], currentVal, true);
                    } else {
                        loadBrandColors(brandId, currentVal);
                    }
                }
            });
        }

        // Sayfa ilk yüklendiğinde (örn. validation hatası sonrası)
        if (initialBrandId) {
            fetch(`{{ route('admin.phones.models-by-brand') }}?brand_id=${initialBrandId}`)
                .then(response => response.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Model Seçiniz</option>';
                    if (data.models && data.models.length > 0) {
                        data.models.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            if (initialModelId && String(model.id) === String(initialModelId)) {
                                option.selected = true;
                            }
                            modelSelect.appendChild(option);
                        });
                        modelSelect.disabled = false;
                    }
                });
            loadBrandColors(initialBrandId, initialColorId);
        } else {
            populateColors(allSystemColors, initialColorId, false);
            if (colorFilterBtn) colorFilterBtn.disabled = true;
        }

        // ================= Seri Numarası İşlemleri =================
        function updateHiddenInput() {
            stockSerialsHidden.value = JSON.stringify(serialNumbers);
            updateEmptyMessage();
        }

        function updateEmptyMessage() {
            if (emptySerialsMessage) {
                emptySerialsMessage.style.display = serialNumbers.length === 0 ? 'block' : 'none';
            }
        }

        function addSerialNumber() {
            const serialNumber = newSerialInput.value.trim();
            if (!serialNumber) {
                alert('Lütfen seri numarası giriniz');
                newSerialInput.focus();
                return;
            }

            if (serialNumbers.includes(serialNumber)) {
                alert('Bu seri numarası listeye zaten eklenmiş.');
                newSerialInput.focus();
                return;
            }

            serialNumbers.push(serialNumber);

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

            newSerialInput.value = '';
            newSerialInput.focus();
            updateHiddenInput();

            serialItem.querySelector('.remove-serial-btn').addEventListener('click', function() {
                removeSerialNumber(this.getAttribute('data-serial'));
            });
        }

        function removeSerialNumber(serialToRemove) {
            serialNumbers = serialNumbers.filter(s => s !== serialToRemove);
            const serialItems = serialNumbersList.querySelectorAll('.remove-serial-btn');
            serialItems.forEach(btn => {
                if (btn.getAttribute('data-serial') === serialToRemove) {
                    btn.closest('div').remove();
                }
            });
            updateHiddenInput();
        }

        if (newSerialInput) {
            newSerialInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addSerialNumber();
                }
            });
        }

        if (addSerialBtn) {
            addSerialBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addSerialNumber();
            });
        }

        // Eski seri numaralarını geri yükle (validation sonrası)
        const oldStockSerials = stockSerialsHidden.value;
        if (oldStockSerials) {
            try {
                const serials = JSON.parse(oldStockSerials);
                if (Array.isArray(serials)) {
                    serials.forEach(serial => {
                        if (serial && !serialNumbers.includes(serial)) {
                            serialNumbers.push(serial);
                            const item = document.createElement('div');
                            item.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border';
                            item.innerHTML = `
                                <div class="flex items-center">
                                    <i class="fas fa-barcode text-gray-500 mr-2"></i>
                                    <span class="font-mono text-sm">${serial}</span>
                                </div>
                                <button type="button" class="text-red-500 hover:text-red-700 remove-serial-btn" data-serial="${serial}">
                                    <i class="fas fa-times"></i>
                                </button>
                            `;
                            serialNumbersList.appendChild(item);
                            item.querySelector('.remove-serial-btn').addEventListener('click', function() {
                                removeSerialNumber(this.getAttribute('data-serial'));
                            });
                        }
                    });
                }
            } catch (e) {
                console.error('Seri numarası parse hatası:', e);
            }
        }
        updateEmptyMessage();

        // ================= Form Gönderimi & Çift Tıklama Engeli =================
        let isSubmitting = false;

        if (phoneForm) {
            phoneForm.addEventListener('submit', function(e) {
                updateHiddenInput();

                if (serialNumbers.length === 0) {
                    e.preventDefault();
                    alert('Lütfen en az bir seri numarası ekleyin.');
                    if (newSerialInput) newSerialInput.focus();
                    return false;
                }

                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }

                isSubmitting = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Kaydediliyor...';
                }
            });
        }
    });
</script>
@endsection
