@extends('layouts.app')

@section('title', 'Detail Surat Keluar')
@section('page-title', 'Detail Surat Keluar')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-0">
        <!-- Header dengan Action Buttons -->
        <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0">
                <h1 class="text-base sm:text-2xl font-bold text-gray-900 truncate">{{ $suratKeluar->nomor_surat }}</h1>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Dibuat oleh: <span class="font-medium">{{ $suratKeluar->user->name }}</span></p>
            </div>
            <div class="flex flex-col xs:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('surat-keluars.edit', $suratKeluar) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-xs sm:text-sm font-medium w-full sm:w-auto">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-1 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="hidden xs:inline">Edit</span>
                </a>
                <form action="{{ route('surat-keluars.destroy', $suratKeluar) }}" method="POST" style="display: inline; width: 100%; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors w-full text-xs sm:text-sm font-medium" onclick="return confirm('Yakin hapus surat ini?')">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-1 sm:mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="hidden xs:inline">Hapus</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Info Grid -->
            <div class="p-4 sm:p-6 border-b border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                <!-- Nomor Surat -->
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Nomor Surat</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base truncate">{{ $suratKeluar->nomor_surat }}</p>
                </div>

                <!-- Tanggal Surat -->
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Tanggal Surat</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">{{ $suratKeluar->tanggal_surat->format('d F Y') }}</p>
                </div>

                <!-- Tujuan -->
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Tujuan</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base truncate">{{ $suratKeluar->tujuan }}</p>
                </div>

                <!-- Perihal -->
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Perihal</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base truncate">{{ $suratKeluar->perihal }}</p>
                </div>

                <!-- Dibuat -->
                <div>
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Dibuat Pada</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">
                        {{ $suratKeluar->created_at->format('d F Y') }} 
                        <span class="text-blue-600" id="createdTime">{{ $suratKeluar->created_at->format('H:i') }}</span>
                    </p>
                </div>

                <!-- Terakhir Diubah -->
                <div>
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Terakhir Diubah</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">
                        {{ $suratKeluar->updated_at->format('d F Y') }} 
                        <span class="text-blue-600" id="updatedTime">{{ $suratKeluar->updated_at->format('H:i') }}</span>
                    </p>
                </div>
            </div>

            <!-- Alamat Penerima -->
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <p class="text-gray-600 text-xs sm:text-sm font-medium mb-2">Alamat Penerima</p>
                <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-900 whitespace-pre-wrap text-xs sm:text-sm">{{ $suratKeluar->alamat_penerima }}</p>
                </div>
            </div>

            <!-- File Section -->
            @if($suratKeluar->file_surat)
                <div class="p-4 sm:p-6 bg-blue-50 border-b border-blue-200">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-3">File Surat</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 sm:p-4 bg-white rounded-lg border border-blue-200 gap-3">
                        <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4z"/>
                            </svg>
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-xs sm:text-sm truncate">{{ basename($suratKeluar->file_surat) }}</p>
                                <p class="text-xs sm:text-sm text-gray-500">PDF Document</p>
                            </div>
                        </div>
                        <a href="{{ route('surat-keluars.download', $suratKeluar) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs sm:text-sm font-medium w-full sm:w-auto flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span class="hidden xs:inline">Download</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="p-4 sm:p-6 bg-gray-50 border-b border-gray-200 text-center">
                    <svg class="w-8 sm:w-12 h-8 sm:h-12 text-gray-300 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4z"/>
                    </svg>
                    <p class="text-gray-600 text-xs sm:text-sm">Tidak ada file yang terlampir</p>
                </div>
            @endif

            <!-- Footer -->
            <div class="p-4 sm:p-6 bg-gray-50 flex justify-center">
                <a href="{{ route('surat-keluars.index') }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs sm:text-sm">
                    ← Kembali ke Daftar Surat
                </a>
            </div>
        </div>
    </div>

    <script>
        // Server timestamps saat halaman load
        const serverCreatedTime = {{ $suratKeluar->created_at->timestamp }};
        const serverUpdatedTime = {{ $suratKeluar->updated_at->timestamp }};
        const pageLoadTime = Math.floor(Date.now() / 1000); // Unix timestamp saat halaman load
        const timeDiff = pageLoadTime - serverCreatedTime; // Selisih waktu
        
        function formatTime(timestamp) {
            const date = new Date(timestamp * 1000);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function updateTimes() {
            // Hitung waktu sekarang di server berdasarkan selisih
            const currentServerTime = Math.floor(Date.now() / 1000);
            const adjustedCreatedTime = serverCreatedTime + (currentServerTime - pageLoadTime);
            const adjustedUpdatedTime = serverUpdatedTime + (currentServerTime - pageLoadTime);
            
            document.getElementById('createdTime').textContent = formatTime(adjustedCreatedTime);
            document.getElementById('updatedTime').textContent = formatTime(adjustedUpdatedTime);
        }

        // Update immediately
        updateTimes();
        
        // Update setiap detik
        setInterval(updateTimes, 1000);
    </script>
@endsection
