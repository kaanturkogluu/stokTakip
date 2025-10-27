@extends('layouts.admin')

@section('title', 'Müşteriler - Admin Panel')
@section('page-title', 'Müşteriler')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Ad, soyad veya telefon...">
            </div>
            <div>
                <label for="debt_filter" class="block text-sm font-medium text-gray-700 mb-2">Borç Durumu</label>
                <select id="debt_filter" 
                        name="debt_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    <option value="has_debt" {{ request('debt_filter') == 'has_debt' ? 'selected' : '' }}>Borcu Olan</option>
                    <option value="no_debt" {{ request('debt_filter') == 'no_debt' ? 'selected' : '' }}>Borcu Olmayan</option>
                </select>
            </div>
            <div>
                <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Sıralama</label>
                <select id="sort_by" 
                        name="sort_by" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Ad</option>
                    <option value="debt" {{ request('sort_by') == 'debt' ? 'selected' : '' }}>Borç</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Kayıt Tarihi</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Ara
                </button>
                <a href="{{ route('admin.customers.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Temizle
                </a>
            </div>
        </form>
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
                            <i class="fas fa-phone mr-2"></i>İletişim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-credit-card mr-2"></i>Borç Durumu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-shopping-cart mr-2"></i>Satış Kayıtları
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
                            ondblclick="showCustomerDebts({{ $customer->id }}, '{{ $customer->full_name }}')"
                            title="Borçları görmek için çift tıklayın">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-xl"></i>
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
                                        <div class="flex items-center">
                                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                                            <span>{{ $customer->phone }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Telefon belirtilmemiş</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <div class="text-sm font-medium {{ $customer->total_debt > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $customer->formatted_total_debt }}
                                    </div>
                                    @if($customer->total_debt > 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Borcu Var
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Temiz
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="font-medium">
                                        {{ $customer->records->count() }} kayıt
                                    </div>
                                    @if($customer->records->count() > 0)
                                        <div class="text-sm text-gray-500">
                                            {{ $customer->records->where('payment_status', 'paid')->count() }} ödendi
                                        </div>
                                    @endif
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
                {{ $customers->appends(request()->query())->links() }}
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
<!-- Customer Debts Modal -->
<div id="debtModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b">
                <h3 class="text-lg font-medium text-gray-900" id="debtModalTitle">
                    <i class="fas fa-credit-card mr-2"></i>
                    Müşteri Borçları
                </h3>
                <button onclick="closeDebtModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="mt-4">
                <div id="debtContent">
                    <!-- Debt content will be loaded here -->
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button onclick="closeDebtModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    Kapat
                </button>
                <button id="paymentButton" onclick="openPaymentModal()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 hidden">
                    <i class="fas fa-money-bill-wave mr-2"></i>Ödeme Al
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Ödeme Al
                </h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="mt-4">
                <form id="paymentForm">
                    <div class="space-y-4">
                        <!-- Customer Info -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">Müşteri Bilgileri</h4>
                            <p class="text-sm text-blue-800" id="paymentCustomerName"></p>
                            <p class="text-sm text-blue-800" id="paymentCustomerDebt"></p>
                        </div>
                        
                        <!-- Payment Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ödeme Tutarı</label>
                            <input type="number" 
                                   id="paymentAmount" 
                                   name="amount" 
                                   step="0.01" 
                                   min="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00"
                                   required>
                        </div>
                        
                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ödeme Yöntemi</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="cash" class="mr-3" checked>
                                    <div class="flex items-center">
                                        <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                        <span class="text-sm font-medium">Nakit</span>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="iban" class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-blue-600 mr-2"></i>
                                        <span class="text-sm font-medium">IBAN</span>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="credit_card" class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-credit-card text-purple-600 mr-2"></i>
                                        <span class="text-sm font-medium">Kredi Kartı</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Payment Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notlar</label>
                            <textarea name="notes" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Ödeme ile ilgili notlar..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button onclick="closePaymentModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    İptal
                </button>
                <button onclick="processPayment()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    <i class="fas fa-check mr-2"></i>Ödemeyi Kaydet
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentCustomerId = null;
let currentCustomerDebts = [];

function showCustomerDebts(customerId, customerName) {
    currentCustomerId = customerId;
    
    // Update modal title
    document.getElementById('debtModalTitle').innerHTML = 
        '<i class="fas fa-credit-card mr-2"></i>' + customerName + ' - Borçları';
    
    // Show loading
    document.getElementById('debtContent').innerHTML = 
        '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i><p class="mt-2 text-gray-600">Borçlar yükleniyor...</p></div>';
    
    // Show modal
    document.getElementById('debtModal').classList.remove('hidden');
    
    // Load customer debts
    fetch(`/admin/customers/${customerId}/debts`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentCustomerDebts = data.debts;
                displayCustomerDebts(data.debts, data.customer);
            } else {
                document.getElementById('debtContent').innerHTML = 
                    '<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><p>Borçlar yüklenirken hata oluştu</p></div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('debtContent').innerHTML = 
                '<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><p>Borçlar yüklenirken hata oluştu</p></div>';
        });
}

function displayCustomerDebts(debts, customer) {
    let html = '';
    
    // Ensure we have valid data
    if (!customer) {
        html = '<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><p>Müşteri bilgileri yüklenemedi</p></div>';
        document.getElementById('debtContent').innerHTML = html;
        return;
    }
    
    if (!debts || debts.length === 0) {
        html = '<div class="text-center py-8 text-gray-500"><i class="fas fa-check-circle text-4xl mb-4"></i><p>Bu müşterinin borcu bulunmuyor</p></div>';
    } else {
        html = `
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-2">Müşteri Bilgileri</h4>
                <p class="text-sm text-gray-600">Ad Soyad: ${customer.name || ''} ${customer.surname || ''}</p>
                <p class="text-sm text-gray-600">Telefon: ${customer.phone || 'Belirtilmemiş'}</p>
                <p class="text-sm font-medium text-red-600">Toplam Borç: ${customer.formatted_total_debt || '0.00 ₺'}</p>
            </div>
            
            <div class="space-y-3">
                <h4 class="font-medium text-gray-900">Borç Detayları</h4>
        `;
        
        debts.forEach((debt, index) => {
            const statusColor = debt.payment_status === 'paid' ? 'text-green-600' : 
                               debt.payment_status === 'partial' ? 'text-yellow-600' : 'text-red-600';
            const statusText = debt.payment_status === 'paid' ? 'Ödendi' : 
                              debt.payment_status === 'partial' ? 'Kısmi Ödeme' : 'Beklemede';
            
            // Format date
            const createdDate = debt.created_at ? new Date(debt.created_at).toLocaleDateString('tr-TR') : 'Tarih belirtilmemiş';
            
            html += `
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h5 class="font-medium text-gray-900">${debt.device_info || 'Cihaz bilgisi yok'}</h5>
                            <p class="text-sm text-gray-500">${createdDate}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${statusColor}">
                            ${statusText}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Satış Fiyatı</p>
                            <p class="font-medium">${debt.formatted_sale_price || '0.00 ₺'}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Ödenen</p>
                            <p class="font-medium text-green-600">${debt.formatted_paid_amount || '0.00 ₺'}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kalan Borç</p>
                            <p class="font-medium text-red-600">${debt.formatted_remaining_debt || '0.00 ₺'}</p>
                        </div>
                    </div>
                    
                    ${debt.notes ? `<p class="text-sm text-gray-600 mt-2"><i class="fas fa-sticky-note mr-1"></i>${debt.notes}</p>` : ''}
                </div>
            `;
        });
        
        html += '</div>';
    }
    
    document.getElementById('debtContent').innerHTML = html;
    
    // Show payment button if there are debts
    if (debts && debts.length > 0 && customer.total_debt > 0) {
        document.getElementById('paymentButton').classList.remove('hidden');
    } else {
        document.getElementById('paymentButton').classList.add('hidden');
    }
}

function closeDebtModal() {
    document.getElementById('debtModal').classList.add('hidden');
    currentCustomerId = null;
    currentCustomerDebts = [];
}

function openPaymentModal() {
    if (!currentCustomerId) return;
    
    // Get customer info from current debts
    const customer = currentCustomerDebts[0]?.customer || {};
    
    if (!customer.name || !customer.surname) {
        Swal.fire({
            title: 'Hata!',
            text: 'Müşteri bilgileri yüklenemedi.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    
    document.getElementById('paymentCustomerName').textContent = `${customer.name} ${customer.surname}`;
    document.getElementById('paymentCustomerDebt').textContent = `Toplam Borç: ${customer.formatted_total_debt || '0.00 ₺'}`;
    
    // Set max payment amount
    document.getElementById('paymentAmount').max = customer.total_debt || 0;
    
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentForm').reset();
}

function processPayment() {
    const form = document.getElementById('paymentForm');
    const formData = new FormData(form);
    
    const amount = parseFloat(formData.get('amount'));
    const paymentMethod = formData.get('payment_method');
    const notes = formData.get('notes');
    
    if (!amount || amount <= 0) {
        alert('Lütfen geçerli bir ödeme tutarı girin.');
        return;
    }
    
    if (amount > currentCustomerDebts[0]?.customer?.total_debt) {
        alert('Ödeme tutarı toplam borçtan fazla olamaz.');
        return;
    }
    
    // Process payment via AJAX
    fetch(`/admin/customers/${currentCustomerId}/payment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            amount: amount,
            payment_method: paymentMethod,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modals
            closePaymentModal();
            closeDebtModal();
            
            // Show success message
            Swal.fire({
                title: 'Başarılı!',
                text: 'Ödeme başarıyla kaydedildi.',
                icon: 'success',
                confirmButtonText: 'Tamam'
            }).then(() => {
                // Reload page to update data
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Hata!',
                text: data.message || 'Ödeme kaydedilirken hata oluştu.',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Hata!',
            text: 'Ödeme kaydedilirken hata oluştu.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
    });
}
</script>

@endsection
