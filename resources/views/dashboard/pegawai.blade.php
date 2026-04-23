@extends('layouts.app')

@section('title', 'Dashboard Pegawai')
@section('page-title', 'Dashboard Pegawai')

@section('content')
    <!-- Stats Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-8 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Surat Keluar</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalSuratUser }}</p>
            </div>
            <svg class="w-16 h-16 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
            </svg>
        </div>
    </div>

    <!-- Surat Keluar -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Surat Keluar (5 Terbaru)</h2>
        </div>

        @if($recentSurats->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nomor Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Perihal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentSurats as $surat)
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $surat->tanggal_surat->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 flex justify-center">
                <a href="{{ route('surat-keluars.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    Lihat Semua Surat →
                </a>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
                </svg>
                <p class="text-gray-500">Belum ada surat keluar</p>
            </div>
        @endif
    </div>
@endsection
