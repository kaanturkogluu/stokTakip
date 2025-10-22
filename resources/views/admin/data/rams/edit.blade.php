@extends('layouts.admin')

@section('title', 'RAM Düzenle - Admin Panel')
@section('page-title', 'RAM Düzenle')

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
            <h3 class="text-lg font-medium text-gray-900">RAM Bilgilerini Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $ram->name }} RAM seçeneğini düzenliyorsunuz</p>
        </div>
        
        <form method="POST" action="{{ route('admin.data.rams.update', $ram) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-microchip mr-2"></i>RAM Adı *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $ram->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="8GB"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div>
                <label for="capacity_gb" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-memory mr-2"></i>Kapasite (GB) *
                </label>
                <div class="relative">
                    <input type="number" 
                           id="capacity_gb" 
                           name="capacity_gb" 
                           value="{{ old('capacity_gb', $ram->capacity_gb) }}"
                           min="1"
                           max="32"
                           step="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('capacity_gb') border-red-500 @enderror"
                           placeholder="8"
                           required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm">GB</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">RAM kapasitesini GB cinsinden girin (1-32 GB arası)</p>
                @error('capacity_gb')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">RAM Önizlemesi</h4>
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-microchip text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">RAM Adı:</span> 
                            <span id="ram_name">{{ $ram->name }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Kapasite:</span> 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" id="capacity_display">
                                {{ old('capacity_gb', $ram->capacity_gb) }} GB
                            </span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Bu kapasite telefonun aynı anda çalıştırabileceği uygulama sayısını etkiler
                        </p>
                    </div>
                </div>
            </div>

            <!-- Performance Indicator -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">
                    <i class="fas fa-tachometer-alt mr-2"></i>Performans Göstergesi
                </h4>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Düşük</span>
                            <span>Orta</span>
                            <span>Yüksek</span>
                            <span>Premium</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-red-500 via-yellow-500 via-green-500 to-blue-500 h-2 rounded-full" 
                                 style="width: {{ min(100, (old('capacity_gb', $ram->capacity_gb) / 16) * 100) }}%"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900" id="performance_level">
                            @php
                                $capacity = old('capacity_gb', $ram->capacity_gb);
                                if ($capacity <= 4) echo 'Düşük';
                                elseif ($capacity <= 8) echo 'Orta';
                                elseif ($capacity <= 12) echo 'Yüksek';
                                else echo 'Premium';
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
                       {{ old('is_active', $ram->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-check mr-1"></i>Aktif RAM seçeneği olarak işaretle
                </label>
            </div>

            <!-- RAM Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">RAM Bilgileri</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Oluşturulma:</span>
                        <span class="ml-1">{{ $ram->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Son Güncelleme:</span>
                        <span class="ml-1">{{ $ram->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Telefon Sayısı:</span>
                        <span class="ml-1">{{ $ram->phones_count ?? 0 }} telefon</span>
                    </div>
                    <div>
                        <span class="font-medium">Durum:</span>
                        <span class="ml-1">
                            @if($ram->is_active)
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
                <a href="{{ route('admin.data.rams') }}" 
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
        const capacityInput = document.getElementById('capacity_gb');
        const nameDisplay = document.getElementById('ram_name');
        const capacityDisplay = document.getElementById('capacity_display');
        const performanceLevel = document.getElementById('performance_level');
        const performanceBar = document.querySelector('.bg-gradient-to-r');
        
        nameInput.addEventListener('input', function() {
            nameDisplay.textContent = this.value;
        });
        
        capacityInput.addEventListener('input', function() {
            const capacity = parseInt(this.value);
            capacityDisplay.textContent = capacity + ' GB';
            
            // Update performance level
            let level = 'Düşük';
            if (capacity <= 4) level = 'Düşük';
            else if (capacity <= 8) level = 'Orta';
            else if (capacity <= 12) level = 'Yüksek';
            else level = 'Premium';
            
            performanceLevel.textContent = level;
            
            // Update performance bar
            const percentage = Math.min(100, (capacity / 16) * 100);
            performanceBar.style.width = percentage + '%';
        });
    });
</script>
@endsection
