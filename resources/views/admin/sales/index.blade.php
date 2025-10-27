@extends('layouts.admin')

@section('title', 'Tüm Satışlar - Admin Panel')
@section('page-title', 'Tüm Satışlar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Toplam Satış</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalSales }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-lira-sign text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Toplam Kar</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalRevenue, 2) }} ₺</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Tahsil Edilen</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalPaid, 2) }} ₺</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Bekleyen Borç</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalDebt, 2) }} ₺</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" action="{{ route('admin.sales.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Telefon, müşteri adı veya seri no...">
            </div>
            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Tarih Filtresi</label>
                <select id="date_filter" 
                        name="date_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tüm Tarihler</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Bugün</option>
                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Dün</option>
                    <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Bu Hafta</option>
                    <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bu Ay</option>
                    <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Geçen Ay</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Ara
                </button>
                <a href="{{ route('admin.sales.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Sales by Date -->
    <div class="space-y-6">
        @forelse($groupedSales as $date => $sales)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Date Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-calendar-day mr-2"></i>
                            {{ \Carbon\Carbon::parse($date)->format('d.m.Y') }} 
                            ({{ \Carbon\Carbon::parse($date)->locale('tr')->dayName }})
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span><i class="fas fa-shopping-cart mr-1"></i>{{ $sales->count() }} Satış</span>
                            <span><i class="fas fa-lira-sign mr-1"></i>{{ number_format($sales->sum(function($sale) { return $sale->sale_price - $sale->purchase_price; }), 2) }} ₺ Kar</span>
                        </div>
                    </div>
                </div>

                <!-- Sales List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-mobile-alt mr-2"></i>Cihaz
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user mr-2"></i>Müşteri
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-lira-sign mr-2"></i>Satış Fiyatı
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-chart-line mr-2"></i>Kar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-money-bill-wave mr-2"></i>Ödenen
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Kalan Borç
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-2"></i>Durum
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-clock mr-2"></i>Satış Saati
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales as $sale)
                                @php
                                    $customerRecord = $sale->customerRecords->first();
                                    $paidAmount = $customerRecord ? $customerRecord->paid_amount : 0;
                                    $remainingDebt = $sale->sale_price - $paidAmount;
                                    $isFullyPaid = $remainingDebt <= 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @php
                                                    $images = is_string($sale->images) ? json_decode($sale->images, true) : $sale->images;
                                                    $firstImage = $images && is_array($images) && count($images) > 0 ? $images[0] : null;
                                                @endphp
                                                @if($firstImage)
                                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $sale->name }}">
                                                @else
                                                    <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <i class="fas fa-mobile-alt text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $sale->name }}</div>
                                                <div class="text-sm text-gray-500">
                                                    @if($sale->brand && $sale->phoneModel)
                                                        {{ $sale->brand->name }} {{ $sale->phoneModel->name }}
                                                    @endif
                                                    @if($sale->storage)
                                                        {{ $sale->storage->name }}
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-400">Seri: {{ $sale->stock_serial }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($customerRecord && $customerRecord->customer)
                                            <div class="text-sm font-medium text-gray-900">{{ $customerRecord->customer->full_name }}</div>
                                            @if($customerRecord->customer->phone)
                                                <div class="text-sm text-gray-500">{{ $customerRecord->customer->phone }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-400">Müşteri bilgisi yok</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-medium">{{ number_format($sale->sale_price, 2) }} ₺</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-medium text-blue-600">{{ number_format($sale->sale_price - $sale->purchase_price, 2) }} ₺</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-medium text-green-600">{{ number_format($paidAmount, 2) }} ₺</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($remainingDebt > 0)
                                            <span class="font-medium text-red-600">{{ number_format($remainingDebt, 2) }} ₺</span>
                                        @else
                                            <span class="font-medium text-green-600">0.00 ₺</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isFullyPaid)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Tam Ödendi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Ödeme Bekliyor
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sale->sold_at->format('H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz satış bulunmuyor</h3>
                <p class="text-gray-500">Sistemde henüz kayıtlı satış bulunmamaktadır.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
