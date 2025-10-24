@extends('layouts.admin')

@section('title', 'Müşteriler - Admin Panel')
@section('page-title', 'Müşteriler')

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
            <h1 class="text-2xl font-bold text-gray-900">Müşteriler</h1>
            <p class="text-gray-600 mt-1">Toplam {{ $customers->total() }} müşteri</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.customers.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-plus mr-2"></i>Yeni Müşteri Ekle
            </a>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-user mr-2"></i>Müşteri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-phone mr-2"></i>Telefon
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-lira-sign mr-2"></i>Borç
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2"></i>Kayıt Tarihi
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-cog mr-2"></i>İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-200" 
                            ondblclick="goToCustomerDetail({{ $customer->id }})"
                            title="Detayları görmek için çift tıklayın">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $customer->full_name }}
                                        </div>
                                        @if($customer->notes)
                                            <div class="text-sm text-gray-500 truncate max-w-xs">
                                                {{ Str::limit($customer->notes, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($customer->phone)
                                        <i class="fas fa-phone mr-1 text-gray-400"></i>
                                        {{ $customer->phone }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium {{ $customer->debt > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $customer->formatted_debt }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200"
                                       title="Görüntüle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition duration-200"
                                       title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteCustomer({{ $customer->id }})" 
                                            class="text-red-600 hover:text-red-900 transition duration-200"
                                            title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Henüz müşteri eklenmemiş</p>
                                    <p class="text-sm">İlk müşteriyi eklemek için yukarıdaki butonu kullanın.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function goToCustomerDetail(customerId) {
    window.location.href = `/admin/customers/${customerId}`;
}

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
