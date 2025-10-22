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
                            required>
                        <option value="">Model Seçiniz</option>
                        @foreach($phoneModels as $phoneModel)
                            <option value="{{ $phoneModel->id }}" {{ old('phone_model_id') == $phoneModel->id ? 'selected' : '' }}>
                                {{ $phoneModel->name }}
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lira-sign mr-2"></i>Alış Fiyat (₺) *
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                           placeholder="89999.00"
                           required>
                    @error('price')
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

                <!-- Memory -->
                <div>
                    <label for="memory_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-memory mr-2"></i>Hafıza
                    </label>
                    <select id="memory_id" 
                            name="memory_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('memory_id') border-red-500 @enderror">
                        <option value="">Hafıza Seçiniz (Opsiyonel)</option>
                        @foreach($memories as $memory)
                            <option value="{{ $memory->id }}" {{ old('memory_id') == $memory->id ? 'selected' : '' }}>
                                {{ $memory->name }} ({{ $memory->capacity_gb }}GB)
                            </option>
                        @endforeach
                    </select>
                    @error('memory_id')
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
                        <i class="fas fa-mobile-alt mr-2"></i>Ekran Boyutu *
                    </label>
                    <select id="screen_id" 
                            name="screen_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('screen_id') border-red-500 @enderror"
                            required>
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
                        <i class="fas fa-camera mr-2"></i>Kamera *
                    </label>
                    <select id="camera_id" 
                            name="camera_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('camera_id') border-red-500 @enderror"
                            required>
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
                <!-- Stock Serial -->
                <div>
                    <label for="stock_serial" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-2"></i>Stok Seri No
                    </label>
                    <input type="text" 
                           id="stock_serial" 
                           name="stock_serial" 
                           value="{{ old('stock_serial') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_serial') border-red-500 @enderror"
                           placeholder="MT001234">
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
    });
</script>
@endsection
