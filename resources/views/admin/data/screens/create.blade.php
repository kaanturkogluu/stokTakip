@extends('layouts.admin')

@section('title', 'Yeni Ekran Ekle - Admin Panel')
@section('page-title', 'Yeni Ekran Ekle')

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
            <h3 class="text-lg font-medium text-gray-900">Ekran Bilgileri</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.data.screens.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-mobile-alt mr-2"></i>Ekran Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="6.7 inç"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Size -->
            <div>
                <label for="size_inches" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-ruler mr-2"></i>Boyut (inç) *
                </label>
                <input type="number" 
                       id="size_inches" 
                       name="size_inches" 
                       value="{{ old('size_inches') }}"
                       step="0.1"
                       min="1"
                       max="20"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size_inches') border-red-500 @enderror"
                       placeholder="6.7"
                       required>
                @error('size_inches')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution -->
            <div>
                <label for="resolution" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-expand-arrows-alt mr-2"></i>Çözünürlük
                </label>
                <input type="text" 
                       id="resolution" 
                       name="resolution" 
                       value="{{ old('resolution') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('resolution') border-red-500 @enderror"
                       placeholder="1080x2340">
                @error('resolution')
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
                    <i class="fas fa-check mr-1"></i>Aktif ekran olarak işaretle
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.data.screens') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Ekranı Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
