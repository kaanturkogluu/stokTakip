@extends('layouts.admin')

@section('title', 'Raporlar - Admin Panel')
@section('page-title', 'Raporlar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Raporlar</h1>
        <p class="text-gray-600 mt-2">Telefon satış ve stok raporları</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-mobile-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Telefon</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPhones }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Satılan Telefon</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $soldPhones }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stokta Telefon</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $availablePhones }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Öne Çıkan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $featuredPhones }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Value Card -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-white bg-opacity-20">
                    <i class="fas fa-coins text-3xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-sm font-medium text-indigo-100">Mevcut Stok Değeri</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($stockValue, 2) }} ₺</p>
                    <p class="text-sm text-indigo-100 mt-2">
                        <i class="fas fa-box mr-1"></i>{{ $availablePhones }} adet telefon stokta
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-white opacity-90">
                    @if($availablePhones > 0)
                        {{ number_format($stockValue / $availablePhones, 2) }} ₺
                    @else
                        0.00 ₺
                    @endif
                </div>
                <p class="text-sm text-indigo-100 mt-1">Ortalama Fiyat</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Brand Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Marka Dağılımı</h3>
            <div class="space-y-3">
                @foreach($brandStats as $brand)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">{{ $brand->name }}</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($brand->count / $totalPhones) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $brand->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Condition Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Durum Dağılımı</h3>
            <div class="space-y-3">
                @foreach($conditionStats as $condition)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">
                            {{ $condition->condition === 'sifir' ? 'Sıfır' : 'İkinci El' }}
                        </span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($condition->count / $totalPhones) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $condition->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Origin Statistics -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Menşei Dağılımı</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($originStats as $origin)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">
                        {{ $origin->origin === 'turkiye' ? 'Türkiye' : 'Yurtdışı' }}
                    </span>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($origin->count / $totalPhones) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $origin->count }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Sales Chart -->
    @if($monthlySales->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aylık Satış Trendi (Son 12 Ay)</h3>
        <div class="h-64 flex items-end space-x-2">
            @foreach($monthlySales as $sale)
                <div class="flex flex-col items-center flex-1">
                    <div class="bg-blue-600 rounded-t" style="height: {{ ($sale->count / $monthlySales->max('count')) * 200 }}px; width: 100%;"></div>
                    <span class="text-xs text-gray-600 mt-2">{{ \Carbon\Carbon::parse($sale->month)->format('M Y') }}</span>
                    <span class="text-xs font-bold text-gray-900">{{ $sale->count }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Top Selling Phones -->
    @if($topSellingPhones->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">En Çok Satılan Telefonlar</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satış Adedi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topSellingPhones as $phone)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $phone->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $phone->brand_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $phone->model_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $phone->sales_count }} adet
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Detaylı Rapor -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4"><i class="fas fa-list-alt mr-2 text-indigo-600"></i>Detaylı Model Raporu</h3>
        @if($detailedReport->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toplam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satılan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stokta</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Değeri</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satış Oranı</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($detailedReport as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $report->brand_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->model_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $report->total_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $report->sold_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $report->available_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($report->stock_value > 0)
                                        <span class="font-semibold text-indigo-600">
                                            {{ number_format($report->stock_value, 2) }} ₺
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($report->total_count > 0)
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($report->sold_count / $report->total_count) * 100 }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600">{{ round(($report->sold_count / $report->total_count) * 100, 1) }}%</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Detaylı rapor verisi bulunamadı.</p>
        @endif
    </div>
</div>
@endsection
