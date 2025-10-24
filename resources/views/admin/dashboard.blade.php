@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
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

        <!-- Sold Phones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Satılan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $soldPhones }}</p>
                </div>
            </div>
        </div>

        <!-- Available Phones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Satışta</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $availablePhones }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Center Section -->
    <div class="flex justify-center">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl">
            <!-- Add New Phone -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="mb-6">
                    <div class="mx-auto w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-plus text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Yeni Telefon Ekle</h3>
                    <p class="text-gray-600 mb-6">Sisteme yeni telefon modeli ekleyin</p>
                </div>
                <a href="{{ route('admin.phones.create') }}" 
                   class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-lg">
                    <i class="fas fa-plus mr-2"></i>Telefon Ekle
                </a>
            </div>

            <!-- View All Phones -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="mb-6">
                    <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-list text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Tüm Telefonlar</h3>
                    <p class="text-gray-600 mb-6">Telefon listesini görüntüleyin ve yönetin</p>
                </div>
                <a href="{{ route('admin.phones.index') }}" 
                   class="inline-block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-lg">
                    <i class="fas fa-list mr-2"></i>Telefonları Görüntüle
                </a>
            </div>

            <!-- Make Sale -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="mb-6">
                    <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shopping-cart text-3xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Satış Yap</h3>
                    <p class="text-gray-600 mb-6">Cihaz satışı gerçekleştirin</p>
                </div>
                <button onclick="openSaleModal()" 
                        class="inline-block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-lg shadow-lg">
                    <i class="fas fa-shopping-cart mr-2"></i>Satış Yap
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Sale Modal -->
<div id="saleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Satış Yap</h3>
                <button onclick="closeSaleModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="saleForm" onsubmit="processSale(event)">
                <div class="mb-4">
                    <label for="serialNumber" class="block text-sm font-medium text-gray-700 mb-2">
                        Seri Numarası
                    </label>
                    <div class="flex space-x-2">
                        <input type="text" 
                               id="serialNumber" 
                               name="serial_number"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Seri numarasını girin..."
                               required>
                        <button type="button" 
                                onclick="searchPhone()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-search mr-1"></i>Sorgula
                        </button>
                    </div>
                    
                    <div id="phoneInfo" class="mt-4 hidden">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div id="phoneDetails"></div>
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           id="confirmDevice" 
                                           class="form-checkbox h-4 w-4 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Cihazı Onayla</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" id="priceSection" style="display: none;">
                    <label for="salePrice" class="block text-sm font-medium text-gray-700 mb-2">
                        Satış Fiyatı (₺)
                    </label>
                    <input type="number" 
                           id="salePrice" 
                           name="sale_price"
                           step="0.01"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Satış fiyatını girin..."
                           required>
                    <div id="priceWarning" class="mt-2 hidden">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-yellow-800">
                                    <strong>Uyarı:</strong> Satış fiyatı alış fiyatından düşük. İşleme devam etmek istiyor musunuz?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" id="noteSection" style="display: none;">
                    <label for="saleNote" class="block text-sm font-medium text-gray-700 mb-2">
                        Satış Notu (Opsiyonel)
                    </label>
                    <textarea id="saleNote" 
                              name="sale_note"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Satış ile ilgili notlarınızı buraya yazabilirsiniz..."></textarea>
                </div>
                
                <div class="mb-4" id="customerSection" style="display: none;">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-3">Müşteri Bilgileri</h4>
                        
                        <!-- Add to Customer List Checkbox -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       id="addToCustomers" 
                                       class="form-checkbox h-4 w-4 text-blue-600 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Cariye Ekle</span>
                            </label>
                        </div>
                        
                        <!-- Customer Form (Hidden by default) -->
                        <div id="customerForm" class="space-y-3" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="customerName" class="block text-xs font-medium text-gray-700 mb-1">
                                        Ad
                                    </label>
                                    <input type="text" 
                                           id="customerName" 
                                           name="customer_name"
                                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Müşteri adı">
                                </div>
                                <div>
                                    <label for="customerSurname" class="block text-xs font-medium text-gray-700 mb-1">
                                        Soyad
                                    </label>
                                    <input type="text" 
                                           id="customerSurname" 
                                           name="customer_surname"
                                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Müşteri soyadı">
                                </div>
                            </div>
                            <div>
                                <label for="customerPhone" class="block text-xs font-medium text-gray-700 mb-1">
                                    Telefon (Opsiyonel)
                                </label>
                                <input type="tel" 
                                       id="customerPhone" 
                                       name="customer_phone"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Telefon numarası">
                            </div>
                        </div>
                        
                        <!-- Payment Options -->
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Ödeme Seçenekleri</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="payment_option" 
                                           value="full" 
                                           checked
                                           class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Tam Ödeme</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="payment_option" 
                                           value="partial" 
                                           class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Kısmi Ödeme</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Partial Payment Amount (Hidden by default) -->
                        <div id="partialPaymentSection" class="mt-3" style="display: none;">
                            <label for="partialAmount" class="block text-xs font-medium text-gray-700 mb-1">
                                Ödeme Miktarı (₺)
                            </label>
                            <input type="number" 
                                   id="partialAmount" 
                                   name="partial_amount"
                                   step="0.01"
                                   min="0.01"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeSaleModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                        İptal
                    </button>
                    <button type="submit" 
                            id="saleButton"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200"
                            disabled>
                        Satış Yap
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Sale Modal Functions
let currentPhone = null;

function openSaleModal() {
    document.getElementById('saleModal').classList.remove('hidden');
    document.getElementById('saleForm').reset();
    document.getElementById('phoneInfo').classList.add('hidden');
    document.getElementById('priceSection').style.display = 'none';
    document.getElementById('noteSection').style.display = 'none';
    document.getElementById('customerSection').style.display = 'none';
    document.getElementById('saleButton').disabled = true;
    document.getElementById('confirmDevice').checked = false;
    currentPhone = null;
}

function closeSaleModal() {
    document.getElementById('saleModal').classList.add('hidden');
    document.getElementById('saleForm').reset();
    document.getElementById('phoneInfo').classList.add('hidden');
    document.getElementById('priceSection').style.display = 'none';
    document.getElementById('noteSection').style.display = 'none';
    document.getElementById('customerSection').style.display = 'none';
    document.getElementById('saleButton').disabled = true;
    document.getElementById('confirmDevice').checked = false;
    currentPhone = null;
}

// Search phone by serial number
function searchPhone() {
    const serialNumber = document.getElementById('serialNumber').value.trim();
    if (serialNumber.length < 3) {
        alert('Lütfen en az 3 karakter girin.');
        return;
    }
    
    searchPhoneBySerial(serialNumber);
}

function searchPhoneBySerial(serialNumber) {
    fetch(`/admin/phones/search-by-serial?serial=${encodeURIComponent(serialNumber)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.phone) {
                currentPhone = data.phone;
                displayPhoneInfo(data.phone);
            } else {
                document.getElementById('phoneInfo').classList.add('hidden');
                document.getElementById('priceSection').style.display = 'none';
                document.getElementById('saleButton').disabled = true;
                alert('Bu seri numarasına sahip cihaz bulunamadı.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('phoneInfo').classList.add('hidden');
            document.getElementById('priceSection').style.display = 'none';
            document.getElementById('saleButton').disabled = true;
            alert('Arama sırasında bir hata oluştu.');
        });
}

function displayPhoneInfo(phone) {
    const phoneInfo = document.getElementById('phoneInfo');
    const phoneDetails = document.getElementById('phoneDetails');
    
    phoneDetails.innerHTML = `
        <div class="text-sm">
            <div class="font-bold text-lg text-gray-900 mb-2">${phone.name}</div>
            <div class="text-gray-600 mb-1"><strong>Marka:</strong> ${phone.brand?.name || 'N/A'}</div>
            <div class="text-gray-600 mb-1"><strong>Model:</strong> ${phone.phone_model?.name || 'N/A'}</div>
            <div class="text-gray-600 mb-1"><strong>Renk:</strong> ${phone.color?.name || 'N/A'}</div>
            <div class="text-gray-600 mb-1"><strong>Depolama:</strong> ${phone.storage?.name || 'N/A'}</div>
            <div class="text-gray-600 mb-1"><strong>Durum:</strong> ${phone.condition === 'sifir' ? 'Sıfır' : 'İkinci El'}</div>
            <div class="text-gray-600 mb-1"><strong>Menşei:</strong> ${phone.origin === 'turkiye' ? 'Türkiye' : 'Yurtdışı'}</div>
            <div class="text-green-600 font-bold text-lg mt-2">Alış Fiyatı: ${parseFloat(phone.purchase_price).toFixed(2)} ₺</div>
            ${phone.is_sold ? '<div class="text-red-600 font-medium mt-2">⚠️ Bu cihaz zaten satılmış!</div>' : ''}
        </div>
    `;
    
    phoneInfo.classList.remove('hidden');
    
    // Handle device confirmation checkbox based on sale status
    const confirmCheckbox = document.getElementById('confirmDevice');
    const checkboxContainer = confirmCheckbox.closest('label').parentElement;
    
    if (phone.is_sold) {
        // Device is already sold - disable checkbox and show message
        confirmCheckbox.disabled = true;
        confirmCheckbox.checked = false;
        
        // Add a message below the checkbox
        if (!checkboxContainer.querySelector('.sold-message')) {
            const soldMessage = document.createElement('div');
            soldMessage.className = 'sold-message text-red-600 text-sm mt-2 font-medium';
            soldMessage.innerHTML = '⚠️ Bu cihaz zaten satılmış - Satış yapılamaz';
            checkboxContainer.appendChild(soldMessage);
        }
    } else {
        // Device is available - enable checkbox and add event listener
        confirmCheckbox.disabled = false;
        confirmCheckbox.checked = false;
        
        // Remove any existing sold message
        const existingMessage = checkboxContainer.querySelector('.sold-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Add event listener for device confirmation checkbox
        confirmCheckbox.addEventListener('change', function() {
            if (this.checked && !phone.is_sold) {
                document.getElementById('priceSection').style.display = 'block';
                document.getElementById('noteSection').style.display = 'block';
                document.getElementById('customerSection').style.display = 'block';
                document.getElementById('salePrice').focus();
            } else {
                document.getElementById('priceSection').style.display = 'none';
                document.getElementById('noteSection').style.display = 'none';
                document.getElementById('customerSection').style.display = 'none';
                document.getElementById('saleButton').disabled = true;
            }
        });
    }
    
    // Add event listener for price input
    document.getElementById('salePrice').addEventListener('input', function() {
        const salePrice = parseFloat(this.value) || 0;
        const purchasePrice = parseFloat(phone.purchase_price);
        
        if (salePrice > 0) {
            if (salePrice < purchasePrice) {
                document.getElementById('priceWarning').classList.remove('hidden');
            } else {
                document.getElementById('priceWarning').classList.add('hidden');
            }
            document.getElementById('saleButton').disabled = false;
        } else {
            document.getElementById('saleButton').disabled = true;
            document.getElementById('priceWarning').classList.add('hidden');
        }
    });

    // Add event listeners for customer form interactions (only once)
    if (!window.customerEventListenersAdded) {
        const addToCustomersCheckbox = document.getElementById('addToCustomers');
        const customerForm = document.getElementById('customerForm');
        const paymentOptions = document.querySelectorAll('input[name="payment_option"]');
        const partialPaymentSection = document.getElementById('partialPaymentSection');
        const partialAmountInput = document.getElementById('partialAmount');

        // Show/hide customer form when checkbox is toggled
        if (addToCustomersCheckbox) {
            addToCustomersCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    customerForm.style.display = 'block';
                } else {
                    customerForm.style.display = 'none';
                }
            });
        }

        // Show/hide partial payment section based on payment option
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.value === 'partial') {
                    partialPaymentSection.style.display = 'block';
                    partialAmountInput.required = true;
                } else {
                    partialPaymentSection.style.display = 'none';
                    partialAmountInput.required = false;
                    partialAmountInput.value = '';
                }
            });
        });

        // Set max value for partial payment
        if (partialAmountInput) {
            partialAmountInput.addEventListener('input', function() {
                const salePrice = parseFloat(document.getElementById('salePrice').value) || 0;
                if (parseFloat(this.value) > salePrice) {
                    this.value = salePrice;
                }
            });
        }
        
        window.customerEventListenersAdded = true;
    }
}

function processSale(event) {
    event.preventDefault();
    
    console.log('processSale function called'); // Debug log
    
    // Check if device is confirmed
    if (!document.getElementById('confirmDevice').checked) {
        Swal.fire({
            title: 'Uyarı!',
            text: 'Lütfen cihazı onaylayın.',
            icon: 'warning',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    
    // Check if device is already sold
    if (currentPhone && currentPhone.is_sold) {
        Swal.fire({
            title: 'Hata!',
            text: 'Bu cihaz zaten satılmış. Satış yapılamaz.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    
    const formData = new FormData(event.target);
    const serialNumber = formData.get('serial_number');
    const salePrice = parseFloat(formData.get('sale_price'));
    const saleNote = formData.get('sale_note');
    const purchasePrice = parseFloat(currentPhone.purchase_price);
    
    // Customer data
    const addToCustomers = document.getElementById('addToCustomers').checked;
    const customerName = formData.get('customer_name');
    const customerSurname = formData.get('customer_surname');
    const customerPhone = formData.get('customer_phone');
    const paymentOption = formData.get('payment_option');
    const partialAmount = parseFloat(formData.get('partial_amount')) || 0;
    
    console.log('Form data:', {
        serialNumber,
        salePrice,
        addToCustomers,
        customerName,
        customerSurname,
        paymentOption,
        partialAmount
    }); // Debug log
    
    // Validate sale price
    if (!salePrice || salePrice <= 0) {
        Swal.fire({
            title: 'Uyarı!',
            text: 'Lütfen geçerli bir satış fiyatı giriniz.',
            icon: 'warning',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    
    // Validate customer form if "Cariye Ekle" is checked
    if (addToCustomers) {
        if (!customerName || !customerSurname) {
            Swal.fire({
                title: 'Uyarı!',
                text: 'Müşteri bilgileri eksik. Ad ve soyad alanları zorunludur.',
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });
            return;
        }
    }
    
    // Validate partial payment
    if (paymentOption === 'partial') {
        if (!partialAmount || partialAmount <= 0) {
            Swal.fire({
                title: 'Uyarı!',
                text: 'Kısmi ödeme miktarı giriniz.',
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });
            return;
        }
        if (partialAmount > salePrice) {
            Swal.fire({
                title: 'Uyarı!',
                text: 'Ödeme miktarı satış fiyatından fazla olamaz.',
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });
            return;
        }
    }
    
    // Check if sale price is lower than purchase price
    if (salePrice < purchasePrice) {
        Swal.fire({
            title: 'Fiyat Uyarısı',
            text: `Satış fiyatı (${salePrice.toFixed(2)} ₺) alış fiyatından (${purchasePrice.toFixed(2)} ₺) düşük. İşleme devam etmek istiyor musunuz?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, Devam Et',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                executeSale(serialNumber, salePrice, saleNote, addToCustomers, customerName, customerSurname, customerPhone, paymentOption, partialAmount);
            }
        });
    } else {
        // Sale price is higher or equal, proceed directly
        executeSale(serialNumber, salePrice, saleNote, addToCustomers, customerName, customerSurname, customerPhone, paymentOption, partialAmount);
    }
}

function executeSale(serialNumber, salePrice, saleNote, addToCustomers, customerName, customerSurname, customerPhone, paymentOption, partialAmount) {
    console.log('executeSale called with:', { 
        serialNumber, salePrice, saleNote, addToCustomers, customerName, customerSurname, customerPhone, paymentOption, partialAmount 
    }); // Debug log
    
    // CSRF token al
    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!tokenElement) {
        Swal.fire({
            title: 'Hata!',
            text: 'CSRF token bulunamadı. Sayfayı yenileyin.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
        return;
    }
    const token = tokenElement.getAttribute('content');
    
    fetch('/admin/phones/sell', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            serial_number: serialNumber,
            sale_price: salePrice,
            sale_note: saleNote,
            add_to_customers: addToCustomers,
            customer_name: customerName,
            customer_surname: customerSurname,
            customer_phone: customerPhone,
            payment_option: paymentOption,
            partial_amount: partialAmount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Başarılı!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Tamam'
            }).then(() => {
                closeSaleModal();
                location.reload(); // Sayfayı yenile
            });
        } else {
            Swal.fire({
                title: 'Hata!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Hata!',
            text: 'Satış işlemi sırasında bir hata oluştu.',
            icon: 'error',
            confirmButtonText: 'Tamam'
        });
    });
}
</script>
@endsection
