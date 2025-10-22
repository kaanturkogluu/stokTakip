@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Phones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-mobile-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Telefon</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPhones }}</p>
                </div>
            </div>
        </div>

        <!-- Featured Phones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Öne Çıkan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $featuredPhones }}</p>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Satış</p>
                    <p class="text-2xl font-bold text-gray-900">₺{{ number_format($phones->sum('price'), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Average Price -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ortalama Fiyat</p>
                    <p class="text-2xl font-bold text-gray-900">₺{{ number_format($phones->avg('price'), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Phones -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Son Eklenen Telefonlar</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fiyat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($phones->take(5) as $phone)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ $phone->images[0] ?? '/images/default-phone.svg' }}" alt="{{ $phone->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $phone->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $phone->color }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $phone->brand }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $phone->model }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺{{ number_format($phone->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($phone->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-star mr-1"></i>
                                    Öne Çıkan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Normal
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Add New Phone -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Yeni Telefon Ekle</h3>
                    <p class="text-sm text-gray-500 mt-1">Sisteme yeni telefon modeli ekleyin</p>
                </div>
                <a href="{{ route('admin.phones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg transition duration-200">
                    <i class="fas fa-plus text-xl"></i>
                </a>
            </div>
        </div>

        <!-- View All Phones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Tüm Telefonlar</h3>
                    <p class="text-sm text-gray-500 mt-1">Telefon listesini görüntüleyin</p>
                </div>
                <button class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg transition duration-200">
                    <i class="fas fa-list text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Reports -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Raporlar</h3>
                    <p class="text-sm text-gray-500 mt-1">Satış raporlarını görüntüleyin</p>
                </div>
                <button class="bg-purple-600 hover:bg-purple-700 text-white p-3 rounded-lg transition duration-200">
                    <i class="fas fa-chart-bar text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
