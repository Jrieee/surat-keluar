@extends('layouts.app')

@section('title', 'Surat Keluar')
@section('page-title', 'Daftar Surat Keluar')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-gray-600">
                @if($isAdmin)
                    Menampilkan semua surat keluar
                @else
                    Menampilkan surat keluar Anda
                @endif
            </p>
        </div>
        <a href="{{ route('surat-keluars.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Surat Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($suratKeluars->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nomor Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Perihal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tujuan</th>
                            @if($isAdmin)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dibuat Oleh</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($suratKeluars as $surat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                        {{ $surat->nomor_surat }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate text-sm text-gray-700">
                                    {{ $surat->perihal }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $surat->tujuan }}
                                </td>
                                @if($isAdmin)
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $surat->user->name }}
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $surat->tanggal_surat->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
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
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $suratKeluars->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
                </svg>
                <p class="text-gray-500 mb-4">Tidak ada surat keluar</p>
                <a href="{{ route('surat-keluars.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Surat Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
