@extends('layouts.app')

@section('title', 'Surat Keluar')
@section('page-title', 'Daftar Surat Keluar')

@section('content')
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
        <div>
            <p class="text-gray-600 text-xs sm:text-base">
                @if($isAdmin)
                    Menampilkan semua surat keluar
                @else
                    Menampilkan surat keluar Anda
                @endif
            </p>
        </div>
        <a href="{{ route('surat-keluars.create') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-xs sm:text-sm w-full sm:w-auto">
            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Surat Baru
        </a>
    </div>

    <!-- Search Box -->
    <div class="mb-6 bg-white rounded-lg shadow p-3 sm:p-4">
        <form method="GET" action="{{ route('surat-keluars.index') }}" class="flex flex-col sm:flex-row gap-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}"
                placeholder="Cari nomor, perihal, tujuan..." 
                class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
            >
            <button type="submit" class="px-4 sm:px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center gap-2 text-sm sm:text-base w-full sm:w-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span class="sm:inline">Cari</span>
            </button>
            @if($search)
                <a href="{{ route('surat-keluars.index') }}" class="px-4 sm:px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium text-sm sm:text-base w-full sm:w-auto text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($suratKeluars->count() > 0)
            @if($search)
                <div class="px-4 sm:px-6 py-3 bg-blue-50 border-b border-blue-200">
                    <p class="text-xs sm:text-sm text-blue-800">
                        Hasil pencarian untuk "<strong>{{ $search }}</strong>" - Ditemukan <strong>{{ $suratKeluars->total() }}</strong> surat
                    </p>
                </div>
            @endif
            
            <!-- Mobile Card View -->
            <div class="block sm:hidden divide-y divide-gray-200">
                @foreach($suratKeluars as $surat)
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                    {{ $surat->nomor_surat }}
                                </a>
                                <p class="text-xs text-gray-500 mt-1">No: {{ $surat->nomor_urut }}</p>
                            </div>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                {{ $surat->tanggal_surat->format('d M Y') }}
                            </span>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Perihal</p>
                            <p class="text-sm text-gray-900">{{ Str::limit($surat->perihal, 60) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Tujuan</p>
                            <p class="text-sm text-gray-900">{{ Str::limit($surat->tujuan, 60) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Dibuat</p>
                                <p class="text-xs text-blue-600 font-medium created-time" data-timestamp="{{ $surat->created_at->timestamp }}">
                                    {{ $surat->created_at->format('H:i') }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs px-2 py-1 bg-blue-50 rounded">
                                    Lihat
                                </a>
                                <a href="{{ route('surat-keluars.edit', $surat) }}" class="text-yellow-600 hover:text-yellow-900 font-medium text-xs px-2 py-1 bg-yellow-50 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('surat-keluars.destroy', $surat) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs px-2 py-1 bg-red-50 rounded" onclick="return confirm('Yakin hapus surat ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left font-medium text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Nomor Surat</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Perihal</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Tujuan</th>
                            @if($isAdmin)
                                <th class="hidden lg:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Dibuat Oleh</th>
                            @endif
                            <th class="hidden sm:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Dibuat Pada</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($suratKeluars as $surat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                    {{ $surat->nomor_urut }}
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs sm:text-sm">
                                        {{ $surat->nomor_surat }}
                                    </a>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 max-w-xs truncate text-sm text-gray-700">
                                    {{ $surat->perihal }}
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                    {{ $surat->tujuan }}
                                </td>
                                @if($isAdmin)
                                    <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $surat->user->name }}
                                    </td>
                                @endif
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                    {{ $surat->tanggal_surat->format('d M Y') }}
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-blue-600 font-medium created-time" data-timestamp="{{ $surat->created_at->timestamp }}">
                                    {{ $surat->created_at->format('H:i') }}
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm space-x-1 sm:space-x-2">
                                    <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                        Lihat
                                    </a>
                                    <a href="{{ route('surat-keluars.edit', $surat) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('surat-keluars.destroy', $surat) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Yakin hapus surat ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50 overflow-x-auto text-center">
                {{ $suratKeluars->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
                </svg>
                @if($search)
                    <p class="text-gray-500 mb-4">Tidak ada surat yang cocok dengan pencarian "<strong>{{ $search }}</strong>"</p>
                    <a href="{{ route('surat-keluars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        ← Lihat Semua Surat
                    </a>
                @else
                    <p class="text-gray-500 mb-4">Tidak ada surat keluar</p>
                    <a href="{{ route('surat-keluars.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Surat Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection

<script>
    const pageLoadTime = Math.floor(Date.now() / 1000); // Unix timestamp saat halaman load
    
    function formatTime(timestamp) {
        const date = new Date(timestamp * 1000);
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    function updateAllTimes() {
        const currentServerTime = Math.floor(Date.now() / 1000);
        
        document.querySelectorAll('.created-time').forEach(element => {
            const serverTimestamp = parseInt(element.getAttribute('data-timestamp'));
            const adjustedTime = serverTimestamp + (currentServerTime - pageLoadTime);
            element.textContent = formatTime(adjustedTime);
        });
    }

    // Update immediately
    updateAllTimes();
    
    // Update setiap detik
    setInterval(updateAllTimes, 1000);
</script>
