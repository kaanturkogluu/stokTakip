@extends('layouts.admin')

@section('title', 'Ödeme Al - Admin Panel')
@section('page-title', 'Ödeme Al')

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

    <!-- Customer Info -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Müşteri Bilgileri</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Müşteri</label>
                    <p class="text-sm text-gray-900 mt-1">{{ $customer->full_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mevcut Borç</label>
                    <p class="text-lg font-bold {{ $customer->debt > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                        {{ $customer->formatted_debt }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telefon</label>
                    <p class="text-sm text-gray-900 mt-1">
                        @if($customer->phone)
                            {{ $customer->phone }}
                        @else
                            <span class="text-gray-400">Belirtilmemiş</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Ödeme Al</h3>
            <p class="text-sm text-gray-600 mt-1">Müşteriden alınan ödemeyi kaydedin</p>
        </div>

        <form method="POST" action="{{ route('admin.customers.payment.process', $customer) }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Ödeme Miktarı (₺) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           step="0.01"
                           min="0.01"
                           max="{{ $customer->debt }}"
                           value="{{ old('amount') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                           placeholder="0.00"
                           required>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Maksimum: {{ $customer->formatted_debt }}</p>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        Ödeme Yöntemi <span class="text-red-500">*</span>
                    </label>
                    <select id="payment_method" 
                            name="payment_method"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payment_method') border-red-500 @enderror"
                            required>
                        <option value="">Ödeme yöntemi seçin</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Nakit</option>
                        <option value="iban" {{ old('payment_method') == 'iban' ? 'selected' : '' }}>IBAN</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kredi Kartı</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Ödeme Notları
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                          placeholder="Ödeme ile ilgili notlar...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Preview -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-900 mb-2">Ödeme Önizlemesi</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-blue-700">Mevcut Borç:</span>
                        <span class="font-medium" id="current-debt">{{ $customer->formatted_debt }}</span>
                    </div>
                    <div>
                        <span class="text-blue-700">Ödeme Miktarı:</span>
                        <span class="font-medium" id="payment-amount">0.00 ₺</span>
                    </div>
                    <div>
                        <span class="text-blue-700">Kalan Borç:</span>
                        <span class="font-medium" id="remaining-debt">{{ $customer->formatted_debt }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.customers.show', $customer) }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    İptal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    <i class="fas fa-money-bill-wave mr-2"></i>Ödemeyi Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const currentDebt = {{ $customer->debt }};
    
    function updatePreview() {
        const paymentAmount = parseFloat(amountInput.value) || 0;
        const remainingDebt = Math.max(0, currentDebt - paymentAmount);
        
        document.getElementById('payment-amount').textContent = paymentAmount.toFixed(2) + ' ₺';
        document.getElementById('remaining-debt').textContent = remainingDebt.toFixed(2) + ' ₺';
    }
    
    amountInput.addEventListener('input', updatePreview);
    updatePreview(); // Initial update
});
</script>
@endsection
