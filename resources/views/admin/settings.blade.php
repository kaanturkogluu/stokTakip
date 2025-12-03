@extends('layouts.admin')

@section('title', 'Site Ayarları - Admin Panel')
@section('page-title', 'Site Ayarları')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
        @csrf
        
        <!-- Site Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">
                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                Site Bilgileri
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Site Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="site_name" 
                           name="site_name" 
                           value="{{ old('site_name', $settings['site_name']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                        İletişim E-postası <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        İletişim Telefonu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="contact_phone" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">
                        WhatsApp Numarası
                    </label>
                    <input type="text" 
                           id="whatsapp_number" 
                           name="whatsapp_number" 
                           value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="sales_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Satış Telefonu
                    </label>
                    <input type="text" 
                           id="sales_phone" 
                           name="sales_phone" 
                           value="{{ old('sales_phone', $settings['sales_phone']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="technical_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Teknik Destek Telefonu
                    </label>
                    <input type="text" 
                           id="technical_phone" 
                           name="technical_phone" 
                           value="{{ old('technical_phone', $settings['technical_phone']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="main_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Ana Hat Telefonu
                    </label>
                    <input type="text" 
                           id="main_phone" 
                           name="main_phone" 
                           value="{{ old('main_phone', $settings['main_phone']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="md:col-span-2">
                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Site Açıklaması
                    </label>
                    <textarea id="site_description" 
                              name="site_description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('site_description', $settings['site_description']) }}</textarea>
                </div>
                
                <div>
                    <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Site Logosu
                    </label>
                    <div class="space-y-4">
                        @if($settings['site_logo'])
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($settings['site_logo']) }}" alt="Site Logo" class="h-16 w-auto rounded-lg border border-gray-300" id="current-logo">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p>Mevcut Logo</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- File Upload Area -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors" id="logo-upload-area">
                            <div class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <label for="logo_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Logo dosyası yükle</span>
                                        <input id="logo_upload" name="logo" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,.svg" onchange="uploadLogo(this)">
                                    </label>
                                    <p class="pl-1">veya sürükleyip bırakın</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG (Max: 2MB)</p>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div id="logo-progress" class="hidden">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Yükleniyor...</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="site_favicon" class="block text-sm font-medium text-gray-700 mb-2">
                        Site İkonu (Favicon)
                    </label>
                    <div class="space-y-4">
                        @if($settings['site_favicon'])
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ $settings['site_favicon'] }}" alt="Site Favicon" class="h-8 w-8 rounded border border-gray-300" id="current-favicon">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p>Mevcut Favicon</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- File Upload Area -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors" id="favicon-upload-area">
                            <div class="space-y-2">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <label for="favicon_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Favicon dosyası yükle</span>
                                        <input id="favicon_upload" name="favicon" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/x-icon,.svg,.ico" onchange="uploadFavicon(this)">
                                    </label>
                                    <p class="pl-1">veya sürükleyip bırakın</p>
                                </div>
                                <p class="text-xs text-gray-500">ICO, PNG, JPG, GIF, SVG (16x16, 32x32 px önerilir)</p>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div id="favicon-progress" class="hidden">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Yükleniyor...</p>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adres <span class="text-red-500">*</span>
                    </label>
                    <textarea id="contact_address" 
                              name="contact_address" 
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required>{{ old('contact_address', $settings['contact_address']) }}</textarea>
                </div>
                
                <div>
                    <label for="working_hours_weekdays" class="block text-sm font-medium text-gray-700 mb-2">
                        Hafta İçi Çalışma Saatleri
                    </label>
                    <input type="text" 
                           id="working_hours_weekdays" 
                           name="working_hours_weekdays" 
                           value="{{ old('working_hours_weekdays', $settings['working_hours_weekdays']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="09:00 - 18:00">
                </div>
                
                <div>
                    <label for="working_hours_saturday" class="block text-sm font-medium text-gray-700 mb-2">
                        Cumartesi Çalışma Saatleri
                    </label>
                    <input type="text" 
                           id="working_hours_saturday" 
                           name="working_hours_saturday" 
                           value="{{ old('working_hours_saturday', $settings['working_hours_saturday']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="10:00 - 16:00">
                </div>
                
                <div>
                    <label for="working_hours_sunday" class="block text-sm font-medium text-gray-700 mb-2">
                        Pazar Çalışma Saatleri
                    </label>
                    <input type="text" 
                           id="working_hours_sunday" 
                           name="working_hours_sunday" 
                           value="{{ old('working_hours_sunday', $settings['working_hours_sunday']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Kapalı">
                </div>
                
                <div>
                    <label for="whatsapp_support" class="block text-sm font-medium text-gray-700 mb-2">
                        WhatsApp Destek Saatleri
                    </label>
                    <input type="text" 
                           id="whatsapp_support" 
                           name="whatsapp_support" 
                           value="{{ old('whatsapp_support', $settings['whatsapp_support']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="7/24">
                </div>
            </div>
        </div>

        <!-- Google Maps Location -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">
                <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                Google Maps Konumu
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="google_maps_latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Enlem (Latitude)
                    </label>
                    <input type="number" 
                           id="google_maps_latitude" 
                           name="google_maps_latitude" 
                           value="{{ old('google_maps_latitude', $settings['google_maps_latitude']) }}"
                           step="0.000001"
                           min="-90"
                           max="90"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="41.1033">
                    <p class="text-xs text-gray-500 mt-1">Örnek: 41.1033 (İstanbul için)</p>
                </div>
                
                <div>
                    <label for="google_maps_longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Boylam (Longitude)
                    </label>
                    <input type="number" 
                           id="google_maps_longitude" 
                           name="google_maps_longitude" 
                           value="{{ old('google_maps_longitude', $settings['google_maps_longitude']) }}"
                           step="0.000001"
                           min="-180"
                           max="180"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="29.0108">
                    <p class="text-xs text-gray-500 mt-1">Örnek: 29.0108 (İstanbul için)</p>
                </div>
                
                <div>
                    <label for="google_maps_zoom" class="block text-sm font-medium text-gray-700 mb-2">
                        Zoom Seviyesi
                    </label>
                    <input type="number" 
                           id="google_maps_zoom" 
                           name="google_maps_zoom" 
                           value="{{ old('google_maps_zoom', $settings['google_maps_zoom']) }}"
                           min="1"
                           max="20"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="15">
                    <p class="text-xs text-gray-500 mt-1">1-20 arası (15 önerilir)</p>
                </div>
                
            </div>
            
            @if($settings['google_maps_latitude'] && $settings['google_maps_longitude'])
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Mevcut Konum Önizlemesi:</h4>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <strong>Enlem:</strong> {{ $settings['google_maps_latitude'] }}<br>
                        <strong>Boylam:</strong> {{ $settings['google_maps_longitude'] }}<br>
                        <strong>Zoom:</strong> {{ $settings['google_maps_zoom'] }}
                    </p>
                    <a href="https://www.google.com/maps?q={{ $settings['google_maps_latitude'] }},{{ $settings['google_maps_longitude'] }}&z={{ $settings['google_maps_zoom'] }}" 
                       target="_blank" 
                       class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i>
                        Google Maps'te Görüntüle
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Social Media Links -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">
                <i class="fas fa-share-alt mr-2 text-green-600"></i>
                Sosyal Medya Bağlantıları
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook URL
                    </label>
                    <input type="url" 
                           id="facebook_url" 
                           name="facebook_url" 
                           value="{{ old('facebook_url', $settings['facebook_url']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://facebook.com/yourpage">
                </div>
                
                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram URL
                    </label>
                    <input type="url" 
                           id="instagram_url" 
                           name="instagram_url" 
                           value="{{ old('instagram_url', $settings['instagram_url']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://instagram.com/yourpage">
                </div>
                
                <div>
                    <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter URL
                    </label>
                    <input type="url" 
                           id="twitter_url" 
                           name="twitter_url" 
                           value="{{ old('twitter_url', $settings['twitter_url']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://twitter.com/yourpage">
                </div>
                
                <div>
                    <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube URL
                    </label>
                    <input type="url" 
                           id="youtube_url" 
                           name="youtube_url" 
                           value="{{ old('youtube_url', $settings['youtube_url']) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://youtube.com/yourchannel">
                </div>
            </div>
        </div>


        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                Ayarları Kaydet
            </button>
        </div>
    </form>
    </div>

    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function uploadLogo(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Dosya boyutu 2MB\'dan büyük olamaz.');
                    input.value = '';
                    return;
                }
                
                // Validate file type (including SVG)
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                const fileExtension = file.name.toLowerCase().split('.').pop();
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                
                if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                    alert('Lütfen sadece resim dosyası seçin (JPG, PNG, GIF, SVG).');
                    input.value = '';
                    return;
                }
                
                // Show progress
                document.getElementById('logo-progress').classList.remove('hidden');
                document.getElementById('logo-upload-area').classList.add('hidden');
                
                // Create FormData
                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', csrfToken);
                
                // Upload file
                fetch('{{ route("admin.settings.upload-logo") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update current logo image
                        const currentLogo = document.getElementById('current-logo');
                        if (currentLogo) {
                            currentLogo.src = data.url;
                        } else {
                            // Create new logo display if doesn't exist
                            const logoContainer = document.querySelector('#logo-upload-area').parentNode;
                            const logoDisplay = document.createElement('div');
                            logoDisplay.className = 'flex items-center space-x-4';
                            logoDisplay.innerHTML = `
                                <div class="flex-shrink-0">
                                    <img src="${data.url}" alt="Site Logo" class="h-16 w-auto rounded-lg border border-gray-300" id="current-logo">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p>Mevcut Logo</p>
                                </div>
                            `;
                            logoContainer.insertBefore(logoDisplay, document.getElementById('logo-upload-area'));
                        }
                        
                        // Show success message
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Logo yüklenirken bir hata oluştu!', 'error');
                })
                .finally(() => {
                    // Hide progress and show upload area
                    document.getElementById('logo-progress').classList.add('hidden');
                    document.getElementById('logo-upload-area').classList.remove('hidden');
                    input.value = '';
                });
            }
        }
        
        function uploadFavicon(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (1MB max for favicon)
                if (file.size > 1 * 1024 * 1024) {
                    alert('Favicon dosya boyutu 1MB\'dan büyük olamaz.');
                    input.value = '';
                    return;
                }
                
                // Validate file type (including SVG and ICO)
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'];
                const fileExtension = file.name.toLowerCase().split('.').pop();
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'ico'];
                
                if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                    alert('Lütfen sadece resim dosyası seçin (JPG, PNG, GIF, SVG, ICO).');
                    input.value = '';
                    return;
                }
                
                // Show progress
                document.getElementById('favicon-progress').classList.remove('hidden');
                document.getElementById('favicon-upload-area').classList.add('hidden');
                
                // Create FormData
                const formData = new FormData();
                formData.append('favicon', file);
                formData.append('_token', csrfToken);
                
                // Upload file
                fetch('{{ route("admin.settings.upload-favicon") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update current favicon image
                        const currentFavicon = document.getElementById('current-favicon');
                        if (currentFavicon) {
                            currentFavicon.src = data.url;
                        } else {
                            // Create new favicon display if doesn't exist
                            const faviconContainer = document.querySelector('#favicon-upload-area').parentNode;
                            const faviconDisplay = document.createElement('div');
                            faviconDisplay.className = 'flex items-center space-x-4';
                            faviconDisplay.innerHTML = `
                                <div class="flex-shrink-0">
                                    <img src="${data.url}" alt="Site Favicon" class="h-8 w-8 rounded border border-gray-300" id="current-favicon">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p>Mevcut Favicon</p>
                                </div>
                            `;
                            faviconContainer.insertBefore(faviconDisplay, document.getElementById('favicon-upload-area'));
                        }
                        
                        // Show success message
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Favicon yüklenirken bir hata oluştu!', 'error');
                })
                .finally(() => {
                    // Hide progress and show upload area
                    document.getElementById('favicon-progress').classList.add('hidden');
                    document.getElementById('favicon-upload-area').classList.remove('hidden');
                    input.value = '';
                });
            }
        }
        
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Logo drag and drop
            const logoUploadArea = document.getElementById('logo-upload-area');
            logoUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });
            
            logoUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });
            
            logoUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('logo_upload').files = files;
                    uploadLogo(document.getElementById('logo_upload'));
                }
            });
            
            // Favicon drag and drop
            const faviconUploadArea = document.getElementById('favicon-upload-area');
            faviconUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });
            
            faviconUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });
            
            faviconUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('favicon_upload').files = files;
                    uploadFavicon(document.getElementById('favicon_upload'));
                }
            });
        });
    </script>

@endsection
