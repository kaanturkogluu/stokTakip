@extends('layouts.admin')

@section('title', 'Telefonlar - Admin Panel')
@section('page-title', 'Telefonlar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Telefonlar</h1>
            <p class="text-gray-600 mt-1">Toplam {{ $phones->total() }} telefon</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.phones.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-plus mr-2"></i>Yeni Telefon Ekle
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" action="{{ route('admin.phones.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Telefon adı veya seri no...">
            </div>
            <div>
                <label for="sale_status_filter" class="block text-sm font-medium text-gray-700 mb-2">Satış Durumu</label>
                <select id="sale_status_filter" 
                        name="sale_status_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    <option value="not_sold" {{ request('sale_status_filter') == 'not_sold' ? 'selected' : '' }}>Satılmadı</option>
                    <option value="sold" {{ request('sale_status_filter') == 'sold' ? 'selected' : '' }}>Satıldı</option>
                </select>
            </div>
            <div>
                <label for="condition_filter" class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                <select id="condition_filter" 
                        name="condition_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tüm Durumlar</option>
                    <option value="sifir" {{ request('condition_filter') == 'sifir' ? 'selected' : '' }}>Sıfır</option>
                    <option value="ikinci_el" {{ request('condition_filter') == 'ikinci_el' ? 'selected' : '' }}>İkinci El</option>
                </select>
            </div>
            <div>
                <label for="featured_filter" class="block text-sm font-medium text-gray-700 mb-2">Öne Çıkan</label>
                <select id="featured_filter" 
                        name="featured_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    <option value="1" {{ request('featured_filter') == '1' ? 'selected' : '' }}>Öne Çıkan</option>
                    <option value="0" {{ request('featured_filter') == '0' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Ara
                </button>
                <a href="{{ route('admin.phones.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Phones Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-mobile-alt mr-2"></i>Telefon
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-tag mr-2"></i>Marka/Model
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2"></i>Özellikler
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-lira-sign mr-2"></i>Alış Fiyatı
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-info-circle mr-2"></i>Durum
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-shopping-cart mr-2"></i>Satış Durumu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2"></i>Tarih
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-cog mr-2"></i>İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($phones as $phone)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @php
                                            $images = is_string($phone->images) ? json_decode($phone->images, true) : $phone->images;
                                            $firstImage = $images && is_array($images) && count($images) > 0 ? $images[0] : null;
                                        @endphp
                                        @if($firstImage)
                                            <img class="h-12 w-12 rounded-lg object-cover" 
                                                 src="{{ $firstImage }}" 
                                                 alt="{{ $phone->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-mobile-alt text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $phone->name }}
                                            @if($phone->is_featured)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1"></i>Öne Çıkan
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $phone->stock_serial ?? 'Seri No Yok' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $phone->brand->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $phone->phoneModel->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $phone->color->name ?? 'N/A' }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $phone->storage->name ?? 'N/A' }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $phone->ram->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="font-medium text-green-600">
                                        {{ number_format($phone->purchase_price, 2) }} ₺
                                    </div>
                                    @if($phone->sale_price)
                                        <div class="text-sm text-blue-600">
                                            Satış: {{ number_format($phone->sale_price, 2) }} ₺
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $phone->condition === 'sifir' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $phone->condition === 'sifir' ? 'Sıfır' : 'İkinci El' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $phone->origin === 'turkiye' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $phone->origin === 'turkiye' ? 'Türkiye' : 'Yurtdışı' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($phone->is_sold)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-check-circle mr-1"></i>Satıldı
                                    </span>
                                    @if($phone->sold_at)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $phone->sold_at->format('d.m.Y') }}
                                        </div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-clock mr-1"></i>Satılmadı
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $phone->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.phones.show', $phone) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200"
                                       title="Görüntüle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.phones.edit', $phone) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition duration-200"
                                       title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deletePhone({{ $phone->id }})" 
                                            class="text-red-600 hover:text-red-900 transition duration-200"
                                            title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-mobile-alt text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Henüz telefon eklenmemiş</p>
                                    <p class="text-sm">İlk telefonu eklemek için yukarıdaki butonu kullanın.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($phones->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $phones->appends(request()->query())->links() }}
            </div>
        @endif
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
