@extends('layouts.admin')

@section('title', 'Telefon Detayı - Admin Panel')
@section('page-title', 'Telefon Detayı')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.phones.index') }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Telefonlara Dön
        </a>
    </div>

    <!-- Phone Details Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $phone->name }}</h1>
                    <p class="text-blue-100 mt-2">{{ $phone->brand->name }} {{ $phone->phoneModel->name }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">{{ number_format($phone->purchase_price, 0, ',', '.') }} ₺</div>
                    @if($phone->sale_price)
                        <div class="text-lg text-blue-200">Satış: {{ number_format($phone->sale_price, 0, ',', '.') }} ₺</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Images -->
                    @if($phone->images && count($phone->images) > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-images mr-2"></i>Görseller
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($phone->images as $image)
                                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ $image }}" 
                                             alt="{{ $phone->name }}" 
                                             class="w-full h-full object-cover hover:scale-105 transition duration-200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($phone->description)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-align-left mr-2"></i>Açıklama
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $phone->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Notes -->
                    @if($phone->notes)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-sticky-note mr-2"></i>Notlar
                            </h3>
                            <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-400">
                                <p class="text-gray-700">{{ $phone->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Specifications -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2"></i>Temel Bilgiler
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Stok Seri No:</span>
                                <span class="font-mono text-sm font-medium">{{ $phone->stock_serial }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durum:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $phone->condition == 'sifir' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $phone->condition == 'sifir' ? 'Sıfır' : 'İkinci El' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Menşei:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $phone->origin == 'turkiye' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $phone->origin == 'turkiye' ? 'Türkiye' : 'Yurtdışı' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Öne Çıkan:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $phone->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $phone->is_featured ? 'Evet' : 'Hayır' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Status -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-shopping-cart mr-2"></i>Satış Durumu
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durum:</span>
                                @if($phone->is_sold)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-check-circle mr-1"></i>Satıldı
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-clock mr-1"></i>Satılmadı
                                    </span>
                                @endif
                            </div>
                            @if($phone->sold_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Satış Tarihi:</span>
                                    <span class="text-sm font-medium">{{ $phone->sold_at->format('d.m.Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-cogs mr-2"></i>Teknik Özellikler
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Marka:</span>
                                <span class="font-medium">{{ $phone->brand->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Model:</span>
                                <span class="font-medium">{{ $phone->phoneModel->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Renk:</span>
                                <div class="flex items-center">
                                    @if($phone->color->hex_code)
                                        <div class="w-4 h-4 rounded-full mr-2 border border-gray-300" 
                                             style="background-color: {{ $phone->color->hex_code }}"></div>
                                    @endif
                                    <span class="font-medium">{{ $phone->color->name }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Depolama:</span>
                                <span class="font-medium">{{ $phone->storage->name }} ({{ $phone->storage->capacity_gb }}GB)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-calendar mr-2"></i>Tarihler
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Eklenme:</span>
                                <span class="text-sm font-medium">{{ $phone->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Güncellenme:</span>
                                <span class="text-sm font-medium">{{ $phone->updated_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 border-t">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    ID: {{ $phone->id }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.phones.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Geri Dön
                    </a>
                    <a href="{{ route('admin.phones.edit', $phone) }}" 
                       class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Düzenle
                    </a>
                    <button onclick="deletePhone({{ $phone->id }})" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Sil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deletePhone(phoneId) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu telefonu silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, Sil!',
        cancelButtonText: 'İptal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // CSRF token al
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Form oluştur ve gönder
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/phones/${phoneId}`;
            
            // CSRF token input
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token;
            form.appendChild(csrfInput);
            
            // Method override input
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Formu body'ye ekle ve gönder
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
