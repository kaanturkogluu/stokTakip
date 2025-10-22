@extends('layouts.app')

@section('title', $phone->name . ' - Macrotech')

@push('styles')
<style>
    .phone-image {
        transition: transform 0.3s ease;
    }
    .phone-image:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-home"></i>
                            <span class="sr-only">Ana Sayfa</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('phones.index') }}" class="text-gray-500 hover:text-gray-700">Telefonlar</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-700">{{ $phone->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Phone Details -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Phone Images -->
                    <div class="p-8">
                        <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center mb-6">
                            @if($phone->images && count($phone->images) > 0)
                                <img src="{{ $phone->images[0] }}" alt="{{ $phone->name }}" class="phone-image max-h-full max-w-full object-contain">
                            @else
                                <i class="fas fa-mobile-alt text-8xl text-gray-400"></i>
                            @endif
                        </div>
                        
                        @if($phone->images && count($phone->images) > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($phone->images as $index => $image)
                                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-200 transition duration-300">
                                        <img src="{{ $image }}" alt="{{ $phone->name }} - Resim {{ $index + 1 }}" class="max-h-full max-w-full object-contain">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Phone Info -->
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $phone->name }}</h1>
                        
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-blue-600">{{ number_format($phone->price, 0, ',', '.') }} ₺</span>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Özellikler</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Marka:</span>
                                    <span class="text-gray-800">{{ $phone->brand }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Model:</span>
                                    <span class="text-gray-800">{{ $phone->model }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Renk:</span>
                                    <span class="text-gray-800">{{ $phone->color }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Depolama:</span>
                                    <span class="text-gray-800">{{ $phone->storage }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">RAM:</span>
                                    <span class="text-gray-800">{{ $phone->ram }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Ekran:</span>
                                    <span class="text-gray-800">{{ $phone->screen_size }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Kamera:</span>
                                    <span class="text-gray-800">{{ $phone->camera }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Batarya:</span>
                                    <span class="text-gray-800">{{ $phone->battery }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">İşletim Sistemi:</span>
                                    <span class="text-gray-800">{{ $phone->os }}</span>
                                </div>
                            </div>
                        </div>

                        @if($phone->description)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Açıklama</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $phone->description }}</p>
                            </div>
                        @endif

                        <!-- Contact Buttons -->
                        <div class="space-y-4">
                            <a href="https://wa.me/{{ $phone->whatsapp_number }}?text=Merhaba, {{ $phone->name }} hakkında bilgi almak istiyorum." target="_blank" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fab fa-whatsapp text-xl mr-3"></i>
                                WhatsApp ile İletişime Geç
                            </a>
                            
                            <a href="tel:{{ $phone->whatsapp_number }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-phone text-xl mr-3"></i>
                                Telefon Et
                            </a>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Önemli Bilgiler</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Ürün durumu: İkinci el / Sıfır</li>
                                <li>• Garanti: 1 yıl</li>
                                <li>• Kargo: Ücretsiz</li>
                                <li>• Teslimat: 1-2 iş günü</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Phones -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Diğer Telefonlar</h2>
            <div class="text-center">
                <a href="{{ route('phones.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    Tüm Telefonları Görüntüle
                </a>
            </div>
        </div>
    </section>

@endsection
