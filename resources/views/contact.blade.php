@extends('layouts.app')

@section('title', 'İletişim - Macrotech')

@push('styles')
<style>
    .contact-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-purple-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">İletişim</h1>
            <p class="text-xl text-blue-100">Macrotech ile iletişime geçin</p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Bizimle İletişime Geçin</h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Macrotech olarak müşteri memnuniyetini ön planda tutuyoruz. 
                            Sorularınız, önerileriniz veya destek talepleriniz için bize ulaşabilirsiniz.
                        </p>
                    </div>

                    <!-- Phone Numbers -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-800">Telefon Numaralarımız</h3>
                        
                        <!-- WhatsApp Numbers -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-700">WhatsApp Destek</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fab fa-whatsapp text-2xl text-green-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Satış Destek</span>
                                    </div>
                                    <a href="https://wa.me/905551234567" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">+90 555 123 45 67</a>
                                </div>
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fab fa-whatsapp text-2xl text-green-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Teknik Destek</span>
                                    </div>
                                    <a href="https://wa.me/905551234568" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">+90 555 123 45 68</a>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Numbers -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-700">Telefon Numaraları</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-phone text-2xl text-blue-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Ana Hat</span>
                                    </div>
                                    <a href="tel:+905551234567" class="text-blue-600 hover:text-blue-800 font-medium">+90 555 123 45 67</a>
                                </div>
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-phone text-2xl text-blue-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Satış</span>
                                    </div>
                                    <a href="tel:+905551234569" class="text-blue-600 hover:text-blue-800 font-medium">+90 555 123 45 69</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-start mb-3">
                            <i class="fas fa-map-marker-alt text-2xl text-blue-500 mr-3 mt-1"></i>
                            <div>
                                <span class="font-semibold text-gray-800 block mb-2">Adres</span>
                                <p class="text-gray-600">Maslak Mahallesi, Büyükdere Caddesi<br>No: 123, Sarıyer/İstanbul</p>
                                <a href="https://maps.google.com/?q=Maslak+Mahallesi+Büyükdere+Caddesi+123+Sarıyer+İstanbul" target="_blank" class="inline-flex items-center mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                    <i class="fas fa-directions mr-2"></i>
                                    Konuma Git
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Map -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Konumumuz</h3>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3003.0!2d29.0!3d41.1!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDA2JzAwLjAiTiAyOcKwMDAnMDAuMCJF!5e0!3m2!1str!2str!4v1234567890123!5m2!1str!2str" 
                                width="100%" 
                                height="400" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-clock text-2xl text-blue-500 mr-3"></i>
                            <span class="font-semibold text-gray-800">Çalışma Saatleri</span>
                        </div>
                        <div class="space-y-1 text-gray-600">
                            <p>Pazartesi - Cuma: 09:00 - 18:00</p>
                            <p>Cumartesi: 10:00 - 16:00</p>
                            <p>Pazar: Kapalı</p>
                            <p class="text-green-600 font-medium">7/24 WhatsApp Destek</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
