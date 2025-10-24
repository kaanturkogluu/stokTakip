@extends('layouts.admin')

@section('title', 'Müşteri Düzenle - Admin Panel')
@section('page-title', 'Müşteri Düzenle')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.customers.show', $customer) }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Müşteri Detayına Dön
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Müşteri Düzenle</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $customer->full_name }} - Bilgileri güncelleyin</p>
        </div>

        <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Ad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $customer->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Müşteri adı"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Surname -->
                <div>
                    <label for="surname" class="block text-sm font-medium text-gray-700 mb-2">
                        Soyad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="surname" 
                           name="surname" 
                           value="{{ old('surname', $customer->surname) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('surname') border-red-500 @enderror"
                           placeholder="Müşteri soyadı"
                           required>
                    @error('surname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telefon
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $customer->phone) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                           placeholder="Telefon numarası (opsiyonel)">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Debt -->
                <div>
                    <label for="debt" class="block text-sm font-medium text-gray-700 mb-2">
                        Borç (₺) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="debt" 
                           name="debt" 
                           value="{{ old('debt', $customer->debt) }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('debt') border-red-500 @enderror"
                           placeholder="0.00"
                           required>
                    @error('debt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notlar
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                          placeholder="Müşteri hakkında notlar...">{{ old('notes', $customer->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.customers.show', $customer) }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    İptal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Güncelle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
