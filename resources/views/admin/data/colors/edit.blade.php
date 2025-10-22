@extends('layouts.admin')

@section('title', 'Renk Düzenle - Admin Panel')
@section('page-title', 'Renk Düzenle')

@section('content')
<div class="max-w-2xl mx-auto">
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
            <h3 class="text-lg font-medium text-gray-900">Renk Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $color->name }} rengini düzenliyorsunuz</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.colors.update', $color) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-palette mr-2"></i>Renk Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $color->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Siyah"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hex Code -->
            <div>
                <label for="hex_code" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-paint-brush mr-2"></i>Hex Kodu
                </label>
                <div class="flex items-center space-x-3">
                    <input type="color" 
                           id="color_picker" 
                           class="w-12 h-12 border border-gray-300 rounded cursor-pointer"
                           value="{{ old('hex_code', $color->hex_code) ?: '#6B7280' }}"
                           onchange="updateHexCode(this.value)">
                    <input type="text" 
                           id="hex_code" 
                           name="hex_code" 
                           value="{{ old('hex_code', $color->hex_code) }}"
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('hex_code') border-red-500 @enderror"
                           placeholder="#000000"
                           pattern="^#[0-9A-Fa-f]{6}$"
                           onchange="updateColorPicker(this.value)">
                </div>
                <p class="text-sm text-gray-500 mt-1">Renk seçici ile seçin veya hex kodunu girin (örn: #FF0000)</p>
                @error('hex_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Renk Önizlemesi</h4>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full border-2 border-gray-200" 
                         id="color_preview" 
                         style="background-color: {{ old('hex_code', $color->hex_code) ?: '#6B7280' }}"></div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Mevcut Renk:</span> 
                            <span id="color_name">{{ $color->name }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Hex Kodu:</span> 
                            <code class="bg-gray-200 px-2 py-1 rounded text-xs" id="hex_display">{{ old('hex_code', $color->hex_code) ?: '#6B7280' }}</code>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $color->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif renk olarak işaretle
                </label>
            </div>

            <!-- Color Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Renk Bilgileri</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Oluşturulma:</span>
                        <span class="ml-1">{{ $color->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Son Güncelleme:</span>
                        <span class="ml-1">{{ $color->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Telefon Sayısı:</span>
                        <span class="ml-1">{{ $color->phones_count ?? 0 }} telefon</span>
                    </div>
                    <div>
                        <span class="font-medium">Durum:</span>
                        <span class="ml-1">
                            @if($color->is_active)
                                <span class="text-green-600 font-medium">Aktif</span>
                            @else
                                <span class="text-red-600 font-medium">Pasif</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.data.colors') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateHexCode(color) {
        document.getElementById('hex_code').value = color;
        document.getElementById('color_preview').style.backgroundColor = color;
        document.getElementById('hex_display').textContent = color;
    }

    function updateColorPicker(hex) {
        if (hex.match(/^#[0-9A-Fa-f]{6}$/)) {
            document.getElementById('color_picker').value = hex;
            document.getElementById('color_preview').style.backgroundColor = hex;
            document.getElementById('hex_display').textContent = hex;
        }
    }

    // Initialize color picker and preview with current values
    document.addEventListener('DOMContentLoaded', function() {
        const hexCode = document.getElementById('hex_code').value;
        if (hexCode) {
            updateColorPicker(hexCode);
        }
        
        // Update preview when name changes
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('color_name').textContent = this.value;
        });
    });
</script>
@endsection
