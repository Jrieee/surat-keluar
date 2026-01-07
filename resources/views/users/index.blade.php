@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
    <div class="mb-3 sm:mb-6">
        <p class="text-gray-600 text-xs sm:text-base">
            Kelola daftar pengguna sistem aplikasi surat keluar
        </p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($users->count() > 0)
            <!-- Mobile Card View -->
            <div class="block sm:hidden divide-y divide-gray-200">
                @foreach($users as $user)
                    <div class="p-3 space-y-2">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-semibold text-xs flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-medium text-gray-900 text-xs sm:text-sm truncate">{{ $user->name }}</p>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium flex-shrink-0 {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-2">
                            <span class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex gap-1 pt-2 border-t border-gray-200">
                            <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs px-2 py-1 bg-blue-50 rounded flex-1 text-center">
                                Lihat
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline; flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-red-600 hover:text-red-900 font-medium text-xs px-2 py-1 bg-red-50 rounded" onclick="return confirm('Yakin hapus user {{ $user->name }}?')">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic px-2 py-1 flex-1 text-center">Akun Sendiri</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table View -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 sm:px-6 py-2 sm:py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Nama & Role</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Terdaftar Sejak</th>
                            <th class="px-4 sm:px-6 py-2 sm:py-3 text-left font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                        <div class="w-8 sm:w-10 h-8 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-semibold text-xs sm:text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <p class="font-medium text-gray-900 text-xs sm:text-sm truncate">{{ $user->name }}</p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium flex-shrink-0 {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 text-sm text-gray-600 truncate">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm space-x-1 sm:space-x-2">
                                    <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                        Lihat
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Yakin hapus user {{ $user->name }}?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 italic">Akun Sendiri</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-2 sm:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50 overflow-x-auto text-xs sm:text-sm">
                {{ $users->links() }}
            </div>
        @else
            <div class="p-6 sm:p-12 text-center">
                <svg class="w-12 sm:w-16 h-12 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5a2 2 0 110-4 2 2 0 010 4zM1.5 16.5s0-4 4.5-4 4.5 4 4.5 4M13 1.5v6m3-3h-6"/>
                </svg>
                <p class="text-gray-500 text-xs sm:text-base">Tidak ada pengguna</p>
            </div>
        @endif
    </div>
@endsection
