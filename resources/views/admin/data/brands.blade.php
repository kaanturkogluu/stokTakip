@extends('layouts.admin')

@section('title', 'Markalar - Admin Panel')
@section('page-title', 'Markalar')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Markalar</h2>
            <p class="text-gray-600 mt-1">Telefon markalarını yönetin</p>
        </div>
        <a href="{{ route('admin.data.brands.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Yeni Marka Ekle
        </a>
    </div>

    <!-- Brands Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model Sayısı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oluşturulma</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($brands as $brand)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($brand->logo)
                                    <img class="h-10 w-10 rounded-lg object-cover mr-3" src="{{ $brand->logo }}" alt="{{ $brand->name }}">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-gray-500"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $brand->name }}</div>
                                    @if($brand->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($brand->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $brand->slug }}</code>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $brand->phone_models_count }} model
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($brand->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Pasif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $brand->created_at->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.data.brands.edit', $brand) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="confirmDeleteBrand('{{ $brand->id }}', '{{ addslashes($brand->name) }}')" class="text-red-600 hover:text-red-900" title="Sil (Arşive Al)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-brand-form-{{ $brand->id }}" action="{{ route('admin.data.brands.destroy', $brand) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-tag text-4xl mb-4"></i>
                            <p class="text-lg font-medium">Henüz marka eklenmemiş</p>
                            <p class="text-sm">İlk markayı eklemek için yukarıdaki butona tıklayın.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-tag text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Marka</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $brands->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Aktif Marka</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $brands->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-cube text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Model</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $brands->sum('phone_models_count') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteBrand(brandId, brandName) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Markayı Sil?',
            text: `"${brandName}" markası arşive alınacaktır. Dilediğinizde geri getirebilirsiniz.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-brand-form-' + brandId).submit();
            }
        });
    } else {
        if (confirm(`"${brandName}" markasını silmek istediğinize emin misiniz?`)) {
            document.getElementById('delete-brand-form-' + brandId).submit();
        }
    }
}
</script>
@endsection
