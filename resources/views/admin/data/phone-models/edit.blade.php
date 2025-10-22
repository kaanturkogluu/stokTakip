@extends('layouts.admin')

@section('title', 'Telefon Modeli Düzenle - Admin Panel')
@section('page-title', 'Telefon Modeli Düzenle')

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
            <h3 class="text-lg font-medium text-gray-900">Telefon Modeli Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $phoneModel->name }} modelini düzenliyorsunuz</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.phone-models.update', $phoneModel) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-cube mr-2"></i>Model Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $phoneModel->name) }}"
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
                    <option value="">Marka seçin...</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $phoneModel->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
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
                          placeholder="Model hakkında kısa açıklama...">{{ old('description', $phoneModel->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image URL -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-image mr-2"></i>Model Resmi URL
                </label>
                <input type="url" 
                       id="image" 
                       name="image" 
                       value="{{ old('image', $phoneModel->image) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror"
                       placeholder="https://example.com/model-image.png">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <!-- Image Preview -->
                @if($phoneModel->image)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 mb-2">Mevcut Resim:</p>
                        <img src="{{ $phoneModel->image }}" alt="{{ $phoneModel->name }}" class="h-16 w-16 object-contain border border-gray-200 rounded-lg">
                    </div>
                @endif
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $phoneModel->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif model olarak işaretle
                </label>
            </div>

            <!-- Model Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Model Bilgileri</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Slug:</span>
                        <code class="bg-gray-200 px-2 py-1 rounded text-xs ml-1">{{ $phoneModel->slug }}</code>
                    </div>
                    <div>
                        <span class="font-medium">Marka:</span>
                        <span class="ml-1">{{ $phoneModel->brand->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Oluşturulma:</span>
                        <span class="ml-1">{{ $phoneModel->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Son Güncelleme:</span>
                        <span class="ml-1">{{ $phoneModel->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Telefon Sayısı:</span>
                        <span class="ml-1">{{ $phoneModel->phones_count ?? 0 }} telefon</span>
                    </div>
                    <div>
                        <span class="font-medium">Durum:</span>
                        <span class="ml-1">
                            @if($phoneModel->is_active)
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
                <a href="{{ route('admin.data.phone-models') }}" 
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
