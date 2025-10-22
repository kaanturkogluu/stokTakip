@extends('layouts.admin')

@section('title', 'Kamera Düzenle - Admin Panel')
@section('page-title', 'Kamera Düzenle')

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
            <h3 class="text-lg font-medium text-gray-900">Kamera Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">Mevcut kamera özelliklerini güncelleyin</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.cameras.update', $camera) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-camera mr-2"></i>Kamera Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $camera->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="48MP Ana Kamera"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Specification -->
            <div>
                <label for="specification" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-cogs mr-2"></i>Özellikler *
                </label>
                <input type="text" 
                       id="specification" 
                       name="specification" 
                       value="{{ old('specification', $camera->specification) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('specification') border-red-500 @enderror"
                       placeholder="48MP + 12MP + 12MP"
                       required>
                @error('specification')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $camera->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif kamera olarak işaretle
                </label>
            </div>

            <!-- Camera Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-eye mr-2"></i>Önizleme
                </h4>
                <div class="flex items-center space-x-3">
                    <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900" id="preview-name">{{ $camera->name }}</div>
                        <div class="text-xs text-gray-500">
                            <code class="bg-gray-200 px-2 py-1 rounded" id="preview-spec">{{ $camera->specification }}</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.data.cameras') }}" 
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
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const specInput = document.getElementById('specification');
    const previewName = document.getElementById('preview-name');
    const previewSpec = document.getElementById('preview-spec');

    function updatePreview() {
        previewName.textContent = nameInput.value || 'Kamera Adı';
        previewSpec.textContent = specInput.value || 'Özellikler';
    }

    nameInput.addEventListener('input', updatePreview);
    specInput.addEventListener('input', updatePreview);
});
</script>
@endsection
