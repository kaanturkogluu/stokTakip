<!-- Navigation -->
<nav class="bg-white shadow-lg relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ App\Models\Setting::getValue('site_logo') }}" alt="{{ App\Models\Setting::getValue('site_name') }} Logo" class="h-10 w-auto">
                    </a>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Ana Sayfa</a>
                <a href="{{ route('phones.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('phones.*') ? 'text-blue-600' : '' }}">Telefonlar</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">İletişim</a>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', App\Models\Setting::getValue('whatsapp_number')) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600 transition duration-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-50 rounded-lg mt-2">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Ana Sayfa</a>
                <a href="{{ route('phones.index') }}" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium transition duration-300 {{ request()->routeIs('phones.*') ? 'text-blue-600' : '' }}">Telefonlar</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">İletişim</a>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', App\Models\Setting::getValue('whatsapp_number')) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white block px-3 py-2 rounded-md text-base font-medium transition duration-300">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Script -->
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const icon = this.querySelector('i');
        
        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            mobileMenu.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
</script>
