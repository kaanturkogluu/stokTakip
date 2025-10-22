@extends('layouts.admin')

@section('title', 'Yeni Renk Ekle - Admin Panel')
@section('page-title', 'Yeni Renk Ekle')

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
            <h3 class="text-lg font-medium text-gray-900">Renk Bilgileri</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.data.colors.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-palette mr-2"></i>Renk Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
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
                           onchange="updateHexCode(this.value)">
                    <input type="text" 
                           id="hex_code" 
                           name="hex_code" 
                           value="{{ old('hex_code') }}"
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

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif renk olarak işaretle
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.data.colors') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Rengi Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateHexCode(color) {
        document.getElementById('hex_code').value = color;
    }

    function updateColorPicker(hex) {
        if (hex.match(/^#[0-9A-Fa-f]{6}$/)) {
            document.getElementById('color_picker').value = hex;
        }
    }

    // Initialize color picker with hex code if exists
    document.addEventListener('DOMContentLoaded', function() {
        const hexInput = document.getElementById('hex_code');
        const colorPicker = document.getElementById('color_picker');
        
        if (hexInput.value && hexInput.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            colorPicker.value = hexInput.value;
        }
    });
</script>
@endsection
