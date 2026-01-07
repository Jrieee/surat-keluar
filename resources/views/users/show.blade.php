@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
    <div class="max-w-2xl mx-auto px-2 sm:px-4 lg:px-0">
        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="p-3 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-lg sm:text-2xl flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h1 class="text-base sm:text-2xl font-bold text-gray-900 truncate">{{ $user->name }}</h1>
                            <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded text-xs sm:text-sm font-medium flex-shrink-0 {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-xs sm:text-sm truncate">{{ $user->email }}</p>
                    </div>
                </div>
                @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors w-full sm:w-auto text-xs sm:text-sm font-medium" onclick="return confirm('Yakin hapus user ini?')">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Hapus User
                        </button>
                    </form>
                @endif
            </div>

            <!-- User Info -->
            <div class="p-3 sm:p-6 border-b border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Email</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base truncate">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Email Verified</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">
                        @if($user->email_verified_at)
                            <span class="text-green-600">✓ Terverifikasi</span>
                        @else
                            <span class="text-yellow-600">Belum Diverifikasi</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="p-3 sm:p-6 border-b border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Terdaftar Sejak</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">{{ $user->created_at->format('d F Y H:i') }}</p>
                </div>
                <div class="min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Terakhir Diubah</p>
                    <p class="text-gray-900 font-semibold text-xs sm:text-base">{{ $user->updated_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="p-3 sm:p-6 bg-gray-50">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Statistik</h3>
                <div class="bg-white p-3 sm:p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium mb-2">Total Surat Keluar</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->suratKeluars()->count() }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-3 sm:p-6 flex justify-center">
                <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs sm:text-sm">
                    ← Kembali ke Daftar User
                </a>
            </div>
        </div>
    </div>
@endsection
