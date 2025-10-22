@extends('layouts.admin')

@section('title', 'Marka Düzenle - Admin Panel')
@section('page-title', 'Marka Düzenle')

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
            <h3 class="text-lg font-medium text-gray-900">Marka Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $brand->name }} markasını düzenliyorsunuz</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.brands.update', $brand) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-2"></i>Marka Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $brand->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Apple"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2"></i>Açıklama
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Marka hakkında kısa açıklama...">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo URL -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-image mr-2"></i>Logo URL
                </label>
                <input type="url" 
                       id="logo" 
                       name="logo" 
                       value="{{ old('logo', $brand->logo) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('logo') border-red-500 @enderror"
                       placeholder="https://example.com/logo.png">
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <!-- Logo Preview -->
                @if($brand->logo)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 mb-2">Mevcut Logo:</p>
                        <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="h-16 w-16 object-contain border border-gray-200 rounded-lg">
                    </div>
                @endif
            </div>

            <!-- Color Matching -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-palette mr-2"></i>Renk Eşleştirmesi
                </label>
                <p class="text-sm text-gray-600 mb-4">Bu marka ile eşleştirilecek renkleri seçiniz. Bir marka birden fazla renk ile eşleşebilir.</p>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($colors as $color)
                        <div class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                            <input type="checkbox" 
                                   id="color_{{ $color->id }}" 
                                   name="colors[]" 
                                   value="{{ $color->id }}"
                                   {{ in_array($color->id, old('colors', $selectedColors)) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="color_{{ $color->id }}" class="flex items-center space-x-2 cursor-pointer">
                                @if($color->hex_code)
                                    <div class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $color->hex_code }}"></div>
                                @else
                                    <div class="w-4 h-4 rounded-full border border-gray-300 bg-gray-200"></div>
                                @endif
                                <span class="text-sm text-gray-700">{{ $color->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                
                @error('colors')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('colors.*')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $brand->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif marka olarak işaretle
                </label>
            </div>

            <!-- Brand Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Marka Bilgileri</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Slug:</span>
                        <code class="bg-gray-200 px-2 py-1 rounded text-xs ml-1">{{ $brand->slug }}</code>
                    </div>
                    <div>
                        <span class="font-medium">Oluşturulma:</span>
                        <span class="ml-1">{{ $brand->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Son Güncelleme:</span>
                        <span class="ml-1">{{ $brand->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Model Sayısı:</span>
                        <span class="ml-1">{{ $brand->phone_models_count ?? 0 }} model</span>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.data.brands') }}" 
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
@endsection
