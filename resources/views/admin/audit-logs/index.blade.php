@extends('layouts.admin')

@section('title', 'İşlem Geçmişi - Admin Panel')
@section('page-title', 'İşlem Geçmişi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Açıklama veya kullanıcı...">
            </div>
            <div>
                <label for="action_filter" class="block text-sm font-medium text-gray-700 mb-2">İşlem Türü</label>
                <select id="action_filter" 
                        name="action_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tüm İşlemler</option>
                    <option value="create" {{ request('action_filter') == 'create' ? 'selected' : '' }}>Oluşturma</option>
                    <option value="update" {{ request('action_filter') == 'update' ? 'selected' : '' }}>Güncelleme</option>
                    <option value="delete" {{ request('action_filter') == 'delete' ? 'selected' : '' }}>Silme</option>
                    <option value="sale" {{ request('action_filter') == 'sale' ? 'selected' : '' }}>Satış</option>
                    <option value="repurchase" {{ request('action_filter') == 'repurchase' ? 'selected' : '' }}>Geri Alma</option>
                    <option value="payment" {{ request('action_filter') == 'payment' ? 'selected' : '' }}>Ödeme</option>
                    <option value="login" {{ request('action_filter') == 'login' ? 'selected' : '' }}>Giriş</option>
                    <option value="logout" {{ request('action_filter') == 'logout' ? 'selected' : '' }}>Çıkış</option>
                </select>
            </div>
            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Tarih Filtresi</label>
                <select id="date_filter" 
                        name="date_filter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tüm Tarihler</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Bugün</option>
                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Dün</option>
                    <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Bu Hafta</option>
                    <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bu Ay</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Ara
                </button>
                <a href="{{ route('admin.audit-logs.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih/Saat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kullanıcı</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Açıklama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Adresi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->created_at->format('d.m.Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->admin)
                                <div class="text-sm font-medium text-gray-900">{{ $log->admin->name }}</div>
                                <div class="text-sm text-gray-500">{{ $log->admin->email }}</div>
                            @else
                                <span class="text-sm text-gray-400">Sistem</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($log->action == 'create') bg-green-100 text-green-800
                                @elseif($log->action == 'update') bg-blue-100 text-blue-800
                                @elseif($log->action == 'delete') bg-red-100 text-red-800
                                @elseif($log->action == 'sale') bg-purple-100 text-purple-800
                                @elseif($log->action == 'repurchase') bg-orange-100 text-orange-800
                                @elseif($log->action == 'payment') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $log->action_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Henüz işlem kaydı bulunmuyor.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection

