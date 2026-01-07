@extends('layouts.app')

@section('title', 'Edit Surat Keluar')
@section('page-title', 'Edit Surat Keluar')

@section('content')
    <div class="max-w-2xl mx-auto px-2 sm:px-4 lg:px-0">
        <div class="bg-white rounded-lg shadow">
            <div class="p-3 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Edit Surat Keluar</h2>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Nomor Surat: <span class="font-medium">{{ $suratKeluar->nomor_surat }}</span></p>
            </div>

            <form action="{{ route('surat-keluars.update', $suratKeluar) }}" method="POST" enctype="multipart/form-data" class="p-3 sm:p-6 space-y-4 sm:space-y-6">
                @csrf
                @method('PUT')

                <!-- Nomor Surat -->
                <div>
                    <label for="nomor_surat" class="block text-xs sm:text-sm font-medium text-gray-900 mb-2">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" readonly class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-xs sm:text-base">
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="block text-xs sm:text-sm font-medium text-gray-900 mb-2">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat->format('Y-m-d')) }}" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs sm:text-base @error('tanggal_surat') border-red-500 @enderror">
                    @error('tanggal_surat')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tujuan -->
                <div>
                    <label for="tujuan" class="block text-xs sm:text-sm font-medium text-gray-900 mb-2">Tujuan Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="tujuan" name="tujuan" value="{{ old('tujuan', $suratKeluar->tujuan) }}" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs sm:text-base @error('tujuan') border-red-500 @enderror">
                    @error('tujuan')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perihal -->
                <div>
                    <label for="perihal" class="block text-xs sm:text-sm font-medium text-gray-900 mb-2">Perihal Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="perihal" name="perihal" value="{{ old('perihal', $suratKeluar->perihal) }}" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs sm:text-base @error('perihal') border-red-500 @enderror">
                    @error('perihal')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Penerima -->
                <div>
                    <label for="alamat_penerima" class="block text-xs sm:text-sm font-medium text-gray-900 mb-2">Alamat Penerima <span class="text-red-500">*</span></label>
                    <textarea id="alamat_penerima" name="alamat_penerima" rows="4" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs sm:text-base @error('alamat_penerima') border-red-500 @enderror">{{ old('alamat_penerima', $suratKeluar->alamat_penerima) }}</textarea>
                    @error('alamat_penerima')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Surat -->
                <div>
                    <label for="file_surat" class="block text-sm font-medium text-gray-900 mb-2">File Surat (PDF) <span class="text-gray-500 text-xs">Opsional, Maks 5MB</span></label>
                    
                    @if($suratKeluar->file_surat)
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1V9.707l-2.146 2.147a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L9 9.707V15.5a1 1 0 01-1 1zm2-1a1 1 0 001-1v-5.586l2.146 2.147a1 1 0 001.414-1.414l-4-4a1 1 0 00-1.414 0l-4 4a1 1 0 001.414 1.414L8 8.914V14.5a1 1 0 001 1z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('surat-keluars.download', $suratKeluar) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    Download file sekarang
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 sm:p-6 text-center cursor-pointer hover:border-blue-500 transition-colors" id="drop-zone">
                        <input type="file" id="file_surat" name="file_surat" accept=".pdf" class="hidden">
                        <svg class="w-8 sm:w-12 h-8 sm:h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <p class="text-gray-700 font-medium text-xs sm:text-base">Klik atau drag file PDF ke sini untuk mengubah</p>
                        <p class="text-gray-500 text-xs sm:text-sm mt-1">Biarkan kosong jika tidak ingin mengubah file</p>
                    </div>
                    <div id="file-name" class="mt-2 text-xs sm:text-sm text-green-600 hidden"></div>
                    @error('file_surat')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 sm:pt-6 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-xs sm:text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('surat-keluars.show', $suratKeluar) }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors font-medium text-xs sm:text-sm text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file_surat');
        const fileName = document.getElementById('file-name');

        dropZone.addEventListener('click', () => fileInput.click());
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            fileInput.files = e.dataTransfer.files;
            updateFileName();
        });
        fileInput.addEventListener('change', updateFileName);

        function updateFileName() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                fileName.textContent = '✓ File baru dipilih: ' + file.name;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        }
    </script>
@endsection
