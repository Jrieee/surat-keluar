@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Surat -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Surat Keluar</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSurat }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Staff</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStaff }}</p>
                </div>
                <svg class="w-12 h-12 text-green-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5a2 2 0 110-4 2 2 0 010 4zM1.5 16.5s0-4 4.5-4 4.5 4 4.5 4M13 1.5v6m3-3h-6"/>
                </svg>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $allUsers->count() }}</p>
                </div>
                <svg class="w-12 h-12 text-purple-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0a9 9 0 1118 0 9 9 0 01-18 0zm2.999-2h.01a9.003 9.003 0 00-5.486 2.13A4.001 4.001 0 0011 10h8a4 4 0 01-4 4h-.5a4 4 0 00-3.995-3.6c.541-.171 1.074-.341 1.6-.51A8.953 8.953 0 0111 6z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Letters -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Surat Keluar Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nomor Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Perihal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dibuat Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentSurats as $surat)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                            {{ $surat->nomor_surat }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate text-sm text-gray-700">
                                        {{ $surat->perihal }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $surat->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $surat->tanggal_surat->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada surat keluar
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 flex justify-center">
                    <a href="{{ route('surat-keluars.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Lihat Semua Surat →
                    </a>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div>
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h2>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @forelse($allUsers as $user)
                        <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->role }}</p>
                                </div>
                            </div>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1" onclick="return confirm('Yakin hapus user ini?')">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            Tidak ada pengguna
                        </div>
                    @endforelse
                </div>
                <div class="p-4 border-t border-gray-200 flex justify-center">
                    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Kelola User →
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
