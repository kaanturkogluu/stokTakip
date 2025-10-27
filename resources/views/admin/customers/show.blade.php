@extends('layouts.admin')

@section('title', 'Müşteri Detayı - Admin Panel')
@section('page-title', 'Müşteri Detayı')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Müşteri Listesine Dön
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Customer Info -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $customer->full_name }}</h3>
                        <p class="text-sm text-gray-600">Müşteri Detayları</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    @if($customer->debt > 0)
                        <a href="{{ route('admin.customers.payment', $customer) }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            <i class="fas fa-money-bill-wave mr-2"></i>Ödeme Al
                        </a>
                    @endif
                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                       class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Düzenle
                    </a>
                    <button onclick="deleteCustomer({{ $customer->id }})" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Sil
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Temel Bilgiler</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                        <p class="text-sm text-gray-900 mt-1">{{ $customer->full_name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefon</label>
                        <p class="text-sm text-gray-900 mt-1">
                            @if($customer->phone)
                                <i class="fas fa-phone mr-1 text-gray-400"></i>
                                {{ $customer->phone }}
                            @else
                                <span class="text-gray-400">Belirtilmemiş</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kayıt Tarihi</label>
                        <p class="text-sm text-gray-900 mt-1">{{ $customer->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>

                <!-- Financial Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Mali Bilgiler</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mevcut Borç</label>
                        <p class="text-2xl font-bold {{ $customer->debt > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                            {{ $customer->formatted_debt }}
                        </p>
                    </div>

                    @if($customer->debt > 0)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-red-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-red-800">
                                    <strong>Uyarı:</strong> Bu müşterinin {{ $customer->formatted_debt }} borcu bulunmaktadır.
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-green-800">
                                    <strong>Bilgi:</strong> Bu müşterinin borcu bulunmamaktadır.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($customer->notes)
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Notlar</h4>
                    <div class="mt-3 bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $customer->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Customer Records -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-shopping-cart mr-2"></i>
                Satış Kayıtları
            </h3>
        </div>
        <div class="overflow-x-auto">
            @if($customer->records->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cihaz</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satış Fiyatı</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ödenen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kalan Borç</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customer->records as $record)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->device_info }}
                                    </div>
                                    @if($record->phone)
                                        <div class="text-sm text-gray-500">
                                            {{ $record->phone->brand->name ?? '' }} {{ $record->phone->phoneModel->name ?? '' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $record->formatted_sale_price }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $record->formatted_paid_amount }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $record->formatted_remaining_debt }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $record->payment_status_color }}">
                                        {{ $record->payment_status_text }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $record->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Henüz satış kaydı bulunmuyor.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment History -->
            @if($customer->payments->count() > 0)
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Ödeme Geçmişi</h4>
                    <div class="mt-4 space-y-3">
                        @foreach($customer->payments->sortByDesc('created_at') as $payment)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">{{ $payment->formatted_amount }}</span>
                                                <span class="text-gray-500 ml-2">- {{ $payment->payment_method_text }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $payment->created_at->format('d.m.Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-600">
                                            Önceki Borç: {{ $payment->formatted_previous_debt }} → 
                                            Kalan Borç: {{ $payment->formatted_remaining_debt }}
                                        </div>
                                        @if($payment->notes)
                                            <div class="mt-2 text-xs text-gray-700 bg-white rounded p-2">
                                                <strong>Not:</strong> {{ $payment->notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Ödeme Geçmişi</h4>
                    <div class="mt-4 text-center py-8">
                        <i class="fas fa-receipt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Henüz ödeme kaydı bulunmuyor</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function deleteCustomer(customerId) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu müşteriyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!",
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
            form.action = `/admin/customers/${customerId}`;
            
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
