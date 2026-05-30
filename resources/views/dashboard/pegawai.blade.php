@extends('layouts.app')

@section('title', 'Dashboard Pegawai')
@section('page-title', 'Dashboard Pegawai')

@section('content')
    <!-- Stats Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-8 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Surat Keluar</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalSurat }}</p>
            </div>
            <svg class="w-16 h-16 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
            </svg>
        </div>
    </div>

    <!-- Action Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Kelola Surat Keluar</h2>
                <p class="text-gray-600 text-sm mt-1">Lihat dan kelola semua surat keluar di sistem</p>
            </div>
            <a href="{{ route('surat-keluars.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Buka Daftar Surat
            </a>
        </div>
    </div>
@endsection
