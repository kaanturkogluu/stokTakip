@extends('layouts.app')

@section('title', $phone->name . ' - ' . App\Models\Setting::getValue('site_name'))

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
                        

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Özellikler</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Marka - Zorunlu -->
                                @if($phone->brand)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Marka:</span>
                                    <span class="text-gray-800">{{ $phone->brand->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Model - Zorunlu -->
                                @if($phone->phone_model)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Model:</span>
                                    <span class="text-gray-800">{{ $phone->phone_model->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Renk - Opsiyonel -->
                                @if($phone->color)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Renk:</span>
                                    <span class="text-gray-800">{{ $phone->color->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Depolama - Zorunlu -->
                                @if($phone->storage)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Depolama:</span>
                                    <span class="text-gray-800">{{ $phone->storage->name }}</span>
                                </div>
                                @endif
                                
                                <!-- RAM - Zorunlu -->
                                @if($phone->ram)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">RAM:</span>
                                    <span class="text-gray-800">{{ $phone->ram->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Ekran - Opsiyonel -->
                                @if($phone->screen)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Ekran:</span>
                                    <span class="text-gray-800">{{ $phone->screen->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Kamera - Opsiyonel -->
                                @if($phone->camera)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Kamera:</span>
                                    <span class="text-gray-800">{{ $phone->camera->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Batarya - Zorunlu -->
                                @if($phone->battery)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Batarya:</span>
                                    <span class="text-gray-800">{{ $phone->battery->name }}</span>
                                </div>
                                @endif
                                
                                <!-- Durum - Zorunlu -->
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Durum:</span>
                                    <span class="text-gray-800">{{ $phone->condition === 'sifir' ? 'Sıfır' : 'İkinci El' }}</span>
                                </div>
                                
                                <!-- Menşei - Zorunlu -->
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-600">Menşei:</span>
                                    <span class="text-gray-800">{{ $phone->origin === 'turkiye' ? 'Türkiye' : 'Yurtdışı' }}</span>
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
                            <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', App\Models\Setting::getValue('whatsapp_number')) }}?text={{ urlencode('Merhaba, ' . $phone->name . ($phone->ram ? ' (' . $phone->ram->name . ' RAM)' : '') . ($phone->storage ? ' ' . $phone->storage->name : '') . ' hakkında bilgi almak istiyorum.') }}" target="_blank" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fab fa-whatsapp text-xl mr-3"></i>
                                WhatsApp ile İletişime Geç
                            </a>
                            
                            <a href="tel:{{ App\Models\Setting::getValue('whatsapp_number') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-phone text-xl mr-3"></i>
                                Telefon Et
                            </a>
                        </div>

                        <!-- Additional Info -->
                        <!-- <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Önemli Bilgiler</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Ürün durumu: İkinci el / Sıfır</li>
                                <li>• Garanti: 1 yıl</li>
                                <li>• Kargo: Ücretsiz</li>
                                <li>• Teslimat: 1-2 iş günü</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Phones -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Diğer Telefonlar </h2>
            
            @if($relatedPhones->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($relatedPhones as $relatedPhone)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                @php
                                    $images = is_string($relatedPhone->images) ? json_decode($relatedPhone->images, true) : $relatedPhone->images;
                                    $firstImage = $images && is_array($images) && count($images) > 0 ? $images[0] : null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ $firstImage }}" alt="{{ $relatedPhone->name }}" class="h-full w-full object-contain">
                                @else
                                    <i class="fas fa-mobile-alt text-4xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $relatedPhone->name }}</h3>
                                <div class="space-y-1 mb-4 text-sm">
                                    @if($relatedPhone->brand)
                                    <p class="text-gray-600"><strong>Marka:</strong> {{ $relatedPhone->brand->name }}</p>
                                    @endif
                                    @if($relatedPhone->phoneModel)
                                    <p class="text-gray-600"><strong>Model:</strong> {{ $relatedPhone->phoneModel->name }}</p>
                                    @endif
                                    @if($relatedPhone->color)
                                    <p class="text-gray-600"><strong>Renk:</strong> {{ $relatedPhone->color->name }}</p>
                                    @endif
                                    @if($relatedPhone->storage)
                                    <p class="text-gray-600"><strong>Depolama:</strong> {{ $relatedPhone->storage->name }}</p>
                                    @endif
                                    @if($relatedPhone->ram)
                                    <p class="text-gray-600"><strong>RAM:</strong> {{ $relatedPhone->ram->name }}</p>
                                    @endif
                                </div>
                                <div class="flex justify-center">
                                    <a href="{{ route('phones.show', $relatedPhone) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 text-center w-full">
                                        Detayları Gör
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <div class="text-center">
                <a href="{{ route('phones.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    Tüm Telefonları Görüntüle
                </a>
            </div>
        </div>
    </section>

@endsection
