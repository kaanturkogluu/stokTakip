@extends('layouts.admin')

@section('title', 'Ekran Düzenle - Admin Panel')
@section('page-title', 'Ekran Düzenle')

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
            <h3 class="text-lg font-medium text-gray-900">Ekran Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $screen->name }} ekran seçeneğini düzenliyorsunuz</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.screens.update', $screen) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-mobile-alt mr-2"></i>Ekran Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $screen->name) }}"
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
                    <i class="fas fa-expand-arrows-alt mr-2"></i>Boyut (inç) *
                </label>
                <div class="relative">
                    <input type="number" 
                           id="size_inches" 
                           name="size_inches" 
                           value="{{ old('size_inches', $screen->size_inches) }}"
                           min="1"
                           max="20"
                           step="0.1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size_inches') border-red-500 @enderror"
                           placeholder="6.7"
                           required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm">inç</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Ekran boyutunu inç cinsinden girin (1-20 inç arası)</p>
                @error('size_inches')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution -->
            <div>
                <label for="resolution" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tv mr-2"></i>Çözünürlük
                </label>
                <input type="text" 
                       id="resolution" 
                       name="resolution" 
                       value="{{ old('resolution', $screen->resolution) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('resolution') border-red-500 @enderror"
                       placeholder="1080x2400">
                <p class="text-sm text-gray-500 mt-1">Çözünürlüğü genişlik x yükseklik formatında girin (örn: 1080x2400)</p>
                @error('resolution')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Screen Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Ekran Önizlemesi</h4>
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-teal-100 text-teal-600">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Ekran Adı:</span> 
                            <span id="screen_name">{{ $screen->name }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Boyut:</span> 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" id="size_display">
                                {{ old('size_inches', $screen->size_inches) }}" inç
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Çözünürlük:</span> 
                            <code class="bg-gray-200 px-2 py-1 rounded text-xs" id="resolution_display">
                                {{ old('resolution', $screen->resolution) ?: 'Belirtilmemiş' }}
                            </code>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Size Category Indicator -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">
                    <i class="fas fa-mobile-alt mr-2"></i>Ekran Boyutu Kategorisi
                </h4>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Küçük</span>
                            <span>Orta</span>
                            <span>Büyük</span>
                            <span>Çok Büyük</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 via-yellow-500 via-orange-500 to-red-500 h-2 rounded-full" 
                                 style="width: {{ min(100, ((old('size_inches', $screen->size_inches) - 1) / 19) * 100) }}%"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900" id="size_category">
                            @php
                                $size = old('size_inches', $screen->size_inches);
                                if ($size <= 5.5) echo 'Küçük';
                                elseif ($size <= 6.5) echo 'Orta';
                                elseif ($size <= 7.5) echo 'Büyük';
                                else echo 'Çok Büyük';
                            @endphp
                        </span>
                    </div>
                </div>
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $screen->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif ekran seçeneği olarak işaretle
                </label>
            </div>

            <!-- Screen Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Ekran Bilgileri</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Oluşturulma:</span>
                        <span class="ml-1">{{ $screen->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Son Güncelleme:</span>
                        <span class="ml-1">{{ $screen->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Telefon Sayısı:</span>
                        <span class="ml-1">{{ $screen->phones_count ?? 0 }} telefon</span>
                    </div>
                    <div>
                        <span class="font-medium">Durum:</span>
                        <span class="ml-1">
                            @if($screen->is_active)
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
                <a href="{{ route('admin.data.screens') }}" 
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
    // Update preview when inputs change
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const sizeInput = document.getElementById('size_inches');
        const resolutionInput = document.getElementById('resolution');
        const nameDisplay = document.getElementById('screen_name');
        const sizeDisplay = document.getElementById('size_display');
        const resolutionDisplay = document.getElementById('resolution_display');
        const sizeCategory = document.getElementById('size_category');
        const sizeBar = document.querySelector('.bg-gradient-to-r');
        
        nameInput.addEventListener('input', function() {
            nameDisplay.textContent = this.value;
        });
        
        sizeInput.addEventListener('input', function() {
            const size = parseFloat(this.value);
            sizeDisplay.textContent = size + '" inç';
            
            // Update size category
            let category = 'Küçük';
            if (size <= 5.5) category = 'Küçük';
            else if (size <= 6.5) category = 'Orta';
            else if (size <= 7.5) category = 'Büyük';
            else category = 'Çok Büyük';
            
            sizeCategory.textContent = category;
            
            // Update size bar
            const percentage = Math.min(100, ((size - 1) / 19) * 100);
            sizeBar.style.width = percentage + '%';
        });
        
        resolutionInput.addEventListener('input', function() {
            resolutionDisplay.textContent = this.value || 'Belirtilmemiş';
        });
    });
</script>
@endsection
