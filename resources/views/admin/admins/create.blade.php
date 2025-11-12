@extends('layouts.admin')

@section('title', 'Yeni Admin Ekle - Admin Panel')
@section('page-title', 'Yeni Admin Ekle')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Ad Soyad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        E-posta <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Şifre <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Şifre Tekrar <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Rol <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror"
                            required>
                        <option value="">Seçiniz</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Süper Admin</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Yönetici</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Personel</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktif
                    </label>
                </div>
            </div>

            <!-- Role Permissions Table -->
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Rol Yetkileri
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">İşlem</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">
                                    <span class="text-red-600">Süper Admin</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">
                                    <span class="text-blue-600">Admin</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">
                                    <span class="text-green-600">Yönetici</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">
                                    <span class="text-yellow-600">Personel</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">Telefon İşlemleri</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-question-circle text-gray-400" title="Özel yetki gerekli"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">Müşteri İşlemleri</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-question-circle text-gray-400" title="Özel yetki gerekli"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">Satış Yapma</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-question-circle text-gray-400" title="Özel yetki gerekli"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">Ödeme Alma</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-question-circle text-gray-400" title="Özel yetki gerekli"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">Rapor Görüntüleme</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-question-circle text-gray-400" title="Özel yetki gerekli"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 bg-yellow-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Admin Yönetimi</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 bg-red-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">Admin Silme</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 bg-blue-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">İşlem Geçmişi</td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <i class="fas fa-times-circle text-red-600"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-start space-x-2 text-xs text-gray-600">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <p class="mb-1"><strong>Not:</strong> Süper Admin tüm yetkilere otomatik sahiptir.</p>
                        <p><strong>Personel</strong> rolü için özel yetkiler tanımlanmalıdır. Diğer roller genel işlemlere erişebilir.</p>
                    </div>
                </div>
            </div>

            <!-- Permissions (Optional - can be expanded later) -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Özel Yetkiler (Opsiyonel)</label>
                <p class="text-xs text-gray-500 mb-2">Süper Admin tüm yetkilere sahiptir. Diğer roller için özel yetkiler tanımlanabilir.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="phones.create" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Telefon Ekle</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="phones.update" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Telefon Düzenle</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="phones.delete" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Telefon Sil</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="sales.create" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Satış Yap</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="customers.create" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Müşteri Ekle</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="customers.update" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Müşteri Düzenle</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="payments.process" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Ödeme Al</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="reports.view" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Rapor Görüntüle</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.admins.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                    İptal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

