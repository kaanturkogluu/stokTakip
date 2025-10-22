@extends('layouts.app')

@section('title', 'Tüm Telefonlar - Macrotech')

@push('styles')
<style>
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

    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Macrotech Telefon Koleksiyonu</h1>
            <p class="text-lg text-gray-600">Teknoloji dünyasının en geniş telefon koleksiyonunu keşfedin</p>
        </div>
    </div>

    <!-- Phones Grid -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($phones->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $phone->name }}</h3>
                                <div class="space-y-1 mb-4 text-sm">
                                    @if($phone->brand)
                                    <p class="text-gray-600"><strong>Marka:</strong> {{ $phone->brand->name }}</p>
                                    @endif
                                    @if($phone->phoneModel)
                                    <p class="text-gray-600"><strong>Model:</strong> {{ $phone->phoneModel->name }}</p>
                                    @endif
                                    @if($phone->color)
                                    <p class="text-gray-600"><strong>Renk:</strong> {{ $phone->color->name }}</p>
                                    @endif
                                    @if($phone->storage)
                                    <p class="text-gray-600"><strong>Depolama:</strong> {{ $phone->storage->name }}</p>
                                    @endif
                                    @if($phone->ram)
                                    <p class="text-gray-600"><strong>RAM:</strong> {{ $phone->ram->name }}</p>
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
                
                <!-- Pagination -->
                @if($phones->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $phones->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <i class="fas fa-mobile-alt text-8xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">Henüz telefon eklenmemiş</h3>
                    <p class="text-gray-500 mb-8">Yakında harika telefonlar burada olacak!</p>
                    <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                        Ana Sayfaya Dön
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection
