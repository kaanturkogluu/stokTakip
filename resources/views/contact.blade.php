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
                            {{ $settings['site_name'] }} olarak müşteri memnuniyetini ön planda tutuyoruz. 
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
                                    @if($settings['whatsapp_number'])
                                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">{{ $settings['whatsapp_number'] }}</a>
                                    @else
                                        <span class="text-gray-500">Belirtilmemiş</span>
                                    @endif
                                </div>
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fab fa-whatsapp text-2xl text-green-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Teknik Destek</span>
                                    </div>
                                    @if($settings['technical_phone'])
                                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['technical_phone']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">{{ $settings['technical_phone'] }}</a>
                                    @else
                                        <span class="text-gray-500">Belirtilmemiş</span>
                                    @endif
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
                                    @if($settings['main_phone'])
                                        <a href="tel:{{ $settings['main_phone'] }}" class="text-blue-600 hover:text-blue-800 font-medium">{{ $settings['main_phone'] }}</a>
                                    @else
                                        <span class="text-gray-500">Belirtilmemiş</span>
                                    @endif
                                </div>
                                <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-phone text-2xl text-blue-500 mr-3"></i>
                                        <span class="font-semibold text-gray-800">Satış</span>
                                    </div>
                                    @if($settings['sales_phone'])
                                        <a href="tel:{{ $settings['sales_phone'] }}" class="text-blue-600 hover:text-blue-800 font-medium">{{ $settings['sales_phone'] }}</a>
                                    @else
                                        <span class="text-gray-500">Belirtilmemiş</span>
                                    @endif
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
                                <p class="text-gray-600">{{ $settings['contact_address'] }}</p>
                                <a href="https://maps.google.com/?q={{ urlencode($settings['contact_address']) }}" target="_blank" class="inline-flex items-center mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
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
                            @if($settings['google_maps_latitude'] && $settings['google_maps_longitude'])
                                <iframe 
                                    src="https://maps.google.com/maps?q={{ $settings['google_maps_latitude'] }},{{ $settings['google_maps_longitude'] }}&z={{ $settings['google_maps_zoom'] }}&output=embed" 
                                    width="100%" 
                                    height="400" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy">
                                </iframe>
                            @else
                                <iframe 
                                    src="https://maps.google.com/maps?q={{ urlencode($settings['contact_address']) }}&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                    width="100%" 
                                    height="400" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @endif
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="contact-card bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-clock text-2xl text-blue-500 mr-3"></i>
                            <span class="font-semibold text-gray-800">Çalışma Saatleri</span>
                        </div>
                        <div class="space-y-1 text-gray-600">
                            <p>Pazartesi - Cuma: {{ $settings['working_hours_weekdays'] }}</p>
                            <p>Cumartesi: {{ $settings['working_hours_saturday'] }}</p>
                            <p>Pazar: {{ $settings['working_hours_sunday'] }}</p>
                            <p class="text-green-600 font-medium">{{ $settings['whatsapp_support'] }} WhatsApp Destek</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
