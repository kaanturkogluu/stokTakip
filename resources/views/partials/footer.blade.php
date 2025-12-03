<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center mb-4">
                    @php
                        $logoUrl = App\Models\Setting::getValue('site_logo');
                        $logoUrl = $logoUrl ? asset($logoUrl) : asset('/images/logo.svg');
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ App\Models\Setting::getValue('site_name') }} Logo" class="h-12 w-auto">
                </div>
                <p class="text-gray-300 mb-4 leading-relaxed">
                    {{ App\Models\Setting::getValue('site_description') }}
                </p>
                <div class="flex space-x-4">
                    @if(App\Models\Setting::getValue('whatsapp_number'))
                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', App\Models\Setting::getValue('whatsapp_number')) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full transition duration-300">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    @endif
                    @if(App\Models\Setting::getValue('instagram_url'))
                        <a href="{{ App\Models\Setting::getValue('instagram_url') }}" target="_blank" class="bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-full transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    @endif
                    @if(App\Models\Setting::getValue('facebook_url'))
                        <a href="{{ App\Models\Setting::getValue('facebook_url') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                    @endif
                    @if(App\Models\Setting::getValue('twitter_url'))
                        <a href="{{ App\Models\Setting::getValue('twitter_url') }}" target="_blank" class="bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-full transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    @endif
                    @if(App\Models\Setting::getValue('youtube_url'))
                        <a href="{{ App\Models\Setting::getValue('youtube_url') }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded-full transition duration-300">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hızlı Linkler</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-300">Ana Sayfa</a></li>
                    <li><a href="{{ route('phones.index') }}" class="text-gray-300 hover:text-white transition duration-300">Telefonlar</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition duration-300">İletişim</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition duration-300">Hakkımızda</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">İletişim Bilgileri</h4>
                <div class="space-y-3">
                    @if(App\Models\Setting::getValue('main_phone'))
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-500 mr-3"></i>
                            <a href="tel:{{ str_replace(['+', ' ', '-'], '', App\Models\Setting::getValue('main_phone')) }}" class="text-gray-300 hover:text-white transition duration-300">{{ App\Models\Setting::getValue('main_phone') }}</a>
                        </div>
                    @endif
                    @if(App\Models\Setting::getValue('contact_email'))
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-500 mr-3"></i>
                            <a href="mailto:{{ App\Models\Setting::getValue('contact_email') }}" class="text-gray-300 hover:text-white transition duration-300">{{ App\Models\Setting::getValue('contact_email') }}</a>
                        </div>
                    @endif
                    @if(App\Models\Setting::getValue('contact_address'))
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-3 mt-1"></i>
                            <span class="text-gray-300">{{ App\Models\Setting::getValue('contact_address') }}</span>
                        </div>
                    @endif
                    @if(App\Models\Setting::getValue('whatsapp_support'))
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-500 mr-3"></i>
                            <span class="text-gray-300">{{ App\Models\Setting::getValue('whatsapp_support') }} Destek</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-300 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} {{ App\Models\Setting::getValue('site_name') }}. Tüm hakları saklıdır.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="{{ route('privacy-policy') }}" class="text-gray-300 hover:text-white transition duration-300">Gizlilik Politikası</a>
                    <a href="{{ route('terms-of-use') }}" class="text-gray-300 hover:text-white transition duration-300">Kullanım Şartları</a>
                    <a href="{{ route('cookie-policy') }}" class="text-gray-300 hover:text-white transition duration-300">Çerez Politikası</a>
                </div>
            </div>
        </div>
    </div>
</footer>
