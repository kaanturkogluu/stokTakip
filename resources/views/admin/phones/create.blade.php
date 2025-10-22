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
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2"></i>Marka *
                    </label>
                    <input type="text" 
                           id="brand" 
                           name="brand" 
                           value="{{ old('brand') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('brand') border-red-500 @enderror"
                           placeholder="Apple"
                           required>
                    @error('brand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cube mr-2"></i>Model *
                    </label>
                    <input type="text" 
                           id="model" 
                           name="model" 
                           value="{{ old('model') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('model') border-red-500 @enderror"
                           placeholder="iPhone 15 Pro Max"
                           required>
                    @error('model')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-palette mr-2"></i>Renk *
                    </label>
                    <input type="text" 
                           id="color" 
                           name="color" 
                           value="{{ old('color') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('color') border-red-500 @enderror"
                           placeholder="Natural Titanium"
                           required>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price and Condition -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lira-sign mr-2"></i>Fiyat (₺) *
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
                    <label for="storage" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hdd mr-2"></i>Depolama *
                    </label>
                    <input type="text" 
                           id="storage" 
                           name="storage" 
                           value="{{ old('storage') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('storage') border-red-500 @enderror"
                           placeholder="256GB"
                           required>
                    @error('storage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Memory -->
                <div>
                    <label for="memory" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-memory mr-2"></i>Hafıza
                    </label>
                    <input type="text" 
                           id="memory" 
                           name="memory" 
                           value="{{ old('memory') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('memory') border-red-500 @enderror"
                           placeholder="8GB">
                    @error('memory')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RAM -->
                <div>
                    <label for="ram" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-microchip mr-2"></i>RAM *
                    </label>
                    <input type="text" 
                           id="ram" 
                           name="ram" 
                           value="{{ old('ram') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ram') border-red-500 @enderror"
                           placeholder="8GB"
                           required>
                    @error('ram')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Screen Size -->
                <div>
                    <label for="screen_size" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-mobile-alt mr-2"></i>Ekran Boyutu *
                    </label>
                    <input type="text" 
                           id="screen_size" 
                           name="screen_size" 
                           value="{{ old('screen_size') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('screen_size') border-red-500 @enderror"
                           placeholder="6.7 inç"
                           required>
                    @error('screen_size')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Camera -->
                <div>
                    <label for="camera" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera mr-2"></i>Kamera *
                    </label>
                    <input type="text" 
                           id="camera" 
                           name="camera" 
                           value="{{ old('camera') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('camera') border-red-500 @enderror"
                           placeholder="48MP + 12MP + 12MP"
                           required>
                    @error('camera')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Battery -->
                <div>
                    <label for="battery" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-battery-full mr-2"></i>Batarya *
                    </label>
                    <input type="text" 
                           id="battery" 
                           name="battery" 
                           value="{{ old('battery') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('battery') border-red-500 @enderror"
                           placeholder="4422 mAh"
                           required>
                    @error('battery')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- OS -->
                <div>
                    <label for="os" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-desktop mr-2"></i>İşletim Sistemi *
                    </label>
                    <input type="text" 
                           id="os" 
                           name="os" 
                           value="{{ old('os') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('os') border-red-500 @enderror"
                           placeholder="iOS 17"
                           required>
                    @error('os')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp Numarası *
                    </label>
                    <input type="text" 
                           id="whatsapp_number" 
                           name="whatsapp_number" 
                           value="{{ old('whatsapp_number') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('whatsapp_number') border-red-500 @enderror"
                           placeholder="905551234567"
                           required>
                    @error('whatsapp_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2"></i>Açıklama *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Telefon hakkında detaylı açıklama..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Notlar
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                          placeholder="Ek notlar...">{{ old('notes') }}</textarea>
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
                        <button type="button" onclick="removeImageInput(this)" class="text-red-500 hover:text-red-700">
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
    }

    function removeImageInput(button) {
        button.parentElement.remove();
    }
</script>
@endsection
