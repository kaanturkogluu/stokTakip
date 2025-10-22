@extends('layouts.app')

@section('title', App\Models\Setting::getValue('site_name') . ' - Telefon Satış - En İyi Fiyatlar')

@push('styles')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .phone-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .phone-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 text-white">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <!-- Floating Phone Icons -->
        <div class="absolute top-20 left-10 text-6xl opacity-10 animate-bounce">
            <i class="fas fa-mobile-alt"></i>
        </div>
        <div class="absolute top-40 right-20 text-4xl opacity-10 animate-pulse">
            <i class="fas fa-mobile-alt"></i>
        </div>
        <div class="absolute bottom-20 left-1/4 text-5xl opacity-10 animate-bounce" style="animation-delay: 1s;">
            <i class="fas fa-mobile-alt"></i>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight">
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                        {{ strtoupper(App\Models\Setting::getValue('site_name')) }}
                    </span>
                    <span class="block text-white">
                        TEKNOLOJİ
                    </span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl lg:text-3xl mb-4 text-blue-100 font-light">
                    En Yeni Modeller • En İyi Fiyatlar
                </p>
                <p class="text-lg md:text-xl mb-12 text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Macrotech olarak teknoloji dünyasında güvenilir çözümler sunuyoruz. 
                    Premium kalitede telefonları uygun fiyatlarla keşfedin. Hızlı teslimat, güvenli alışveriş ve 7/24 müşteri desteği ile yanınızdayız.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    <a href="{{ route('phones.index') }}" class="group bg-white text-blue-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-2xl">
                        <i class="fas fa-mobile-alt mr-3"></i>
                        Telefonları Keşfet
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="https://wa.me/905551234567" target="_blank" class="group bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl">
                        <i class="fab fa-whatsapp mr-3"></i>
                        WhatsApp Destek
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-blue-400 mb-2">500+</div>
                        <div class="text-gray-300">Mutlu Müşteri</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-purple-400 mb-2">50+</div>
                        <div class="text-gray-300">Telefon Modeli</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-green-400 mb-2">24/7</div>
                        <div class="text-gray-300">Müşteri Desteği</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-2xl text-white opacity-60"></i>
        </div>
    </section>

    <!-- Featured Phones Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Macrotech Öne Çıkan Ürünler</h2>
                <p class="text-lg text-gray-600">Teknoloji dünyasının en popüler ve en çok tercih edilen telefon modelleri</p>
            </div>
            
            @if($phones->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($phones as $phone)
                        <div class="phone-card bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="h-64 bg-gray-200 flex items-center justify-center">
                                @php
                                    $images = is_string($phone->images) ? json_decode($phone->images, true) : $phone->images;
                                    $firstImage = $images && is_array($images) && count($images) > 0 ? $images[0] : null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ $firstImage }}" alt="{{ $phone->name }}" class="h-full w-full object-contain">
                                @else
                                    <i class="fas fa-mobile-alt text-6xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $phone->name }}</h3>
                                <div class="space-y-2 mb-4">
                                    @if($phone->brand)
                                    <p class="text-sm text-gray-600"><strong>Marka:</strong> {{ $phone->brand->name }}</p>
                                    @endif
                                    @if($phone->phoneModel)
                                    <p class="text-sm text-gray-600"><strong>Model:</strong> {{ $phone->phoneModel->name }}</p>
                                    @endif
                                    @if($phone->color)
                                    <p class="text-sm text-gray-600"><strong>Renk:</strong> {{ $phone->color->name }}</p>
                                    @endif
                                    @if($phone->storage)
                                    <p class="text-sm text-gray-600"><strong>Depolama:</strong> {{ $phone->storage->name }}</p>
                                    @endif
                                </div>
                                <div class="flex justify-center">
                                    <a href="{{ route('phones.show', $phone) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition duration-300">
                                        Detayları Gör
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-mobile-alt text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Henüz telefon eklenmemiş</h3>
                    <p class="text-gray-500">Yakında harika telefonlar burada olacak!</p>
                </div>
            @endif
            
            <div class="text-center mt-12">
                <a href="{{ route('phones.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    Tüm Telefonları Görüntüle
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Neden Macrotech'i Tercih Etmelisiniz?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Hızlı Teslimat</h3>
                    <p class="text-gray-600">Siparişinizi aynı gün kargoya veriyoruz</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Güvenli Alışveriş</h3>
                    <p class="text-gray-600">%100 güvenli ödeme ve teslimat garantisi</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">7/24 Destek</h3>
                    <p class="text-gray-600">WhatsApp üzerinden anında destek alın</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">İletişime Geçin</h2>
            <p class="text-lg text-gray-600 mb-8">Sorularınız için bize ulaşın</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/905551234567" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    <i class="fab fa-whatsapp"></i> WhatsApp ile İletişim
                </a>
                <a href="tel:+905551234567" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    <i class="fas fa-phone"></i> Telefon Et
                </a>
            </div>
        </div>
    </section>

@endsection
