@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-2xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    </div>
                </div>
                @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('Yakin hapus user ini?')">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Hapus User
                        </button>
                    </form>
                @endif
            </div>

            <!-- User Info -->
            <div class="p-6 border-b border-gray-200 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Nama</p>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Email</p>
                    <p class="text-gray-900 font-semibold">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Role</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Email Verified</p>
                    <p class="text-gray-900 font-semibold">
                        @if($user->email_verified_at)
                            <span class="text-green-600">✓ Terverifikasi</span>
                        @else
                            <span class="text-yellow-600">Belum Diverifikasi</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="p-6 border-b border-gray-200 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Terdaftar Sejak</p>
                    <p class="text-gray-900 font-semibold">{{ $user->created_at->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Terakhir Diubah</p>
                    <p class="text-gray-900 font-semibold">{{ $user->updated_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="p-6 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Surat Keluar</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $user->suratKeluars()->count() }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 flex justify-center">
                <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-900 font-medium">
                    ← Kembali ke Daftar User
                </a>
            </div>
        </div>
    </div>
@endsection
