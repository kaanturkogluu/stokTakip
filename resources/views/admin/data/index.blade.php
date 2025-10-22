@extends('layouts.admin')

@section('title', 'Veri Yönetimi - Admin Panel')
@section('page-title', 'Veri Yönetimi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900">Veri Yönetimi</h2>
        <p class="text-gray-600 mt-2">Telefon verilerini yönetmek için aşağıdaki kategorilerden birini seçin</p>
    </div>

    <!-- Data Management Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Brands Card -->
        <a href="{{ route('admin.data.brands') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-300">
                        <i class="fas fa-tag text-2xl text-blue-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Markalar</h3>
                <p class="text-gray-600 text-sm">Telefon markalarını yönetin ve düzenleyin</p>
            </div>
        </a>

        <!-- Phone Models Card -->
        <a href="{{ route('admin.data.phone-models') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-green-100 group-hover:bg-green-200 transition-colors duration-300">
                        <i class="fas fa-cube text-2xl text-green-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Modeller</h3>
                <p class="text-gray-600 text-sm">Telefon modellerini yönetin ve düzenleyin</p>
            </div>
        </a>

        <!-- Colors Card -->
        <a href="{{ route('admin.data.colors') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-purple-100 group-hover:bg-purple-200 transition-colors duration-300">
                        <i class="fas fa-palette text-2xl text-purple-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Renkler</h3>
                <p class="text-gray-600 text-sm">Telefon renklerini yönetin ve düzenleyin</p>
            </div>
        </a>

        <!-- Storage Card -->
        <a href="{{ route('admin.data.storages') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-yellow-100 group-hover:bg-yellow-200 transition-colors duration-300">
                        <i class="fas fa-hdd text-2xl text-yellow-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-yellow-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Depolama</h3>
                <p class="text-gray-600 text-sm">Depolama kapasitelerini yönetin</p>
            </div>
        </a>

        <!-- Memory Card -->
        <a href="{{ route('admin.data.memories') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-indigo-100 group-hover:bg-indigo-200 transition-colors duration-300">
                        <i class="fas fa-memory text-2xl text-indigo-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-indigo-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Hafıza</h3>
                <p class="text-gray-600 text-sm">Hafıza kapasitelerini yönetin</p>
            </div>
        </a>

        <!-- RAM Card -->
        <a href="{{ route('admin.data.rams') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-red-100 group-hover:bg-red-200 transition-colors duration-300">
                        <i class="fas fa-microchip text-2xl text-red-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-red-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">RAM</h3>
                <p class="text-gray-600 text-sm">RAM kapasitelerini yönetin</p>
            </div>
        </a>

        <!-- Screen Card -->
        <a href="{{ route('admin.data.screens') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-teal-100 group-hover:bg-teal-200 transition-colors duration-300">
                        <i class="fas fa-mobile-alt text-2xl text-teal-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-teal-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Ekranlar</h3>
                <p class="text-gray-600 text-sm">Ekran boyutlarını yönetin</p>
            </div>
        </a>

        <!-- Camera Card -->
        <a href="{{ route('admin.data.cameras') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-pink-100 group-hover:bg-pink-200 transition-colors duration-300">
                        <i class="fas fa-camera text-2xl text-pink-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-pink-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Kameralar</h3>
                <p class="text-gray-600 text-sm">Kamera özelliklerini yönetin</p>
            </div>
        </a>

        <!-- Battery Card -->
        <a href="{{ route('admin.data.batteries') }}" class="group bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-full bg-orange-100 group-hover:bg-orange-200 transition-colors duration-300">
                        <i class="fas fa-battery-full text-2xl text-orange-600"></i>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Bataryalar</h3>
                <p class="text-gray-600 text-sm">Batarya kapasitelerini yönetin</p>
            </div>
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white">
        <div class="text-center">
            <h3 class="text-xl font-semibold mb-2">Veri Yönetimi Özeti</h3>
            <p class="text-blue-100">Tüm telefon verilerini tek yerden yönetin</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <div class="text-center">
                <div class="text-2xl font-bold">9</div>
                <div class="text-sm text-blue-100">Veri Kategorisi</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">∞</div>
                <div class="text-sm text-blue-100">Sınırsız Kayıt</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">100%</div>
                <div class="text-sm text-blue-100">Veri Tutarlılığı</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">24/7</div>
                <div class="text-sm text-blue-100">Erişim</div>
            </div>
        </div>
    </div>
</div>
@endsection
