@extends('layouts.app')

@section('title', 'Surat Keluar')
@section('page-title', 'Daftar Surat Keluar')

@section('content')
    <div class="mb-3 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
        <div>
            <p class="text-gray-600 text-xs sm:text-base">
                @if($isAdmin)
                    Menampilkan semua surat keluar
                @else
                    Menampilkan surat keluar Anda
                @endif
            </p>
        </div>
        <a href="{{ route('surat-keluars.create') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-xs sm:text-sm w-full sm:w-auto">
            Buat Surat Baru
        </a>
    </div>

    <!-- SEARCH -->
    <div class="mb-3 sm:mb-6 bg-white rounded-lg shadow p-2 sm:p-4">
        <form method="GET" action="{{ route('surat-keluars.index') }}" class="flex gap-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}"
                placeholder="Cari nomor, perihal, tujuan..." 
                class="flex-1 px-4 py-2 border rounded-lg"
            >
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Cari
            </button>

            @if($search)
                <a href="{{ route('surat-keluars.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($suratKeluars->count() > 0)

            <!-- MOBILE -->
            <div class="block sm:hidden divide-y">
                @foreach($suratKeluars as $surat)
                    <div class="p-3">
                        <p class="text-xs text-gray-500">
                            No: {{ $suratKeluars->firstItem() + $loop->index }}
                        </p>
                        <p class="font-medium text-blue-600">
                            {{ $surat->nomor_surat }}
                        </p>
                        <p class="text-sm">{{ $surat->perihal }}</p>
                    </div>
                @endforeach
            </div>

            <!-- DESKTOP -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nomor Surat</th>
                            <th class="px-6 py-3 text-left">Perihal</th>
                            <th class="px-6 py-3 text-left">Tujuan</th>
                            @if($isAdmin)
                                <th class="px-6 py-3 text-left">Dibuat Oleh</th>
                            @endif
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($suratKeluars as $surat)
                            <tr class="border-t">

                                <!-- NOMOR FIX -->
                                <td class="px-6 py-4">
                                    {{ $suratKeluars->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 text-blue-600">
                                    {{ $surat->nomor_surat }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $surat->perihal }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $surat->tujuan }}
                                </td>

                                @if($isAdmin)
                                    <td class="px-6 py-4">
                                        {{ $surat->user->name }}
                                    </td>
                                @endif

                                <td class="px-6 py-4">
                                    {{ $surat->tanggal_surat->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('surat-keluars.show', $surat) }}" class="text-blue-600">Lihat</a>
                                    <a href="{{ route('surat-keluars.edit', $surat) }}" class="text-yellow-600">Edit</a>

                                    <form action="{{ route('surat-keluars.destroy', $surat) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus?')" class="text-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4">
                {{ $suratKeluars->links() }}
            </div>

        @else
            <div class="p-6 text-center text-gray-500">
                Tidak ada data
            </div>
        @endif
    </div>
@endsection