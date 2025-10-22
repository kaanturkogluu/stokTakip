<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center mb-4">
                    <img src="/images/logo.svg" alt="Macrotech Logo" class="h-12 w-auto">
                </div>
                <p class="text-gray-300 mb-4 leading-relaxed">
                    Teknoloji dünyasında güvenilir çözümler sunan Macrotech, premium kalitede telefonları 
                    uygun fiyatlarla müşterilerine ulaştırmaktadır. 7/24 müşteri desteği ile yanınızdayız.
                </p>
                <div class="flex space-x-4">
                    <a href="https://wa.me/905551234567" target="_blank" class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full transition duration-300">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>
                    <a href="https://www.instagram.com/macrotech" target="_blank" class="bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-full transition duration-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="https://www.facebook.com/macrotech" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition duration-300">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="https://www.twitter.com/macrotech" target="_blank" class="bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-full transition duration-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/macrotech" target="_blank" class="bg-blue-700 hover:bg-blue-800 text-white p-3 rounded-full transition duration-300">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hızlı Linkler</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-300">Ana Sayfa</a></li>
                    <li><a href="{{ route('phones.index') }}" class="text-gray-300 hover:text-white transition duration-300">Telefonlar</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition duration-300">İletişim</a></li>
                    <li><a href="#about" class="text-gray-300 hover:text-white transition duration-300">Hakkımızda</a></li>
                    <li><a href="#support" class="text-gray-300 hover:text-white transition duration-300">Destek</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">İletişim Bilgileri</h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-blue-500 mr-3"></i>
                        <a href="tel:+905551234567" class="text-gray-300 hover:text-white transition duration-300">+90 555 123 45 67</a>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-3"></i>
                        <a href="mailto:info@macrotech.com" class="text-gray-300 hover:text-white transition duration-300">info@macrotech.com</a>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-3 mt-1"></i>
                        <span class="text-gray-300">İstanbul, Türkiye</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-500 mr-3"></i>
                        <span class="text-gray-300">7/24 Destek</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-300 text-sm mb-4 md:mb-0">
                    &copy; 2024 Macrotech. Tüm hakları saklıdır.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#privacy" class="text-gray-300 hover:text-white transition duration-300">Gizlilik Politikası</a>
                    <a href="#terms" class="text-gray-300 hover:text-white transition duration-300">Kullanım Şartları</a>
                    <a href="#cookies" class="text-gray-300 hover:text-white transition duration-300">Çerez Politikası</a>
                </div>
            </div>
        </div>
    </div>
</footer>
