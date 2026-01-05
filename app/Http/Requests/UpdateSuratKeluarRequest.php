<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // authorization ditangani di policy/controller
    }

    public function rules(): array
    {
        $suratKeluar = $this->route('surat_keluar');

        return [
            'nomor_surat' => [
                'required',
                'string',
                'max:50',
                Rule::unique('surat_keluars', 'nomor_surat')->ignore($suratKeluar?->id),
            ],
            'tanggal_surat' => 'required|date|date_format:Y-m-d',
            'tujuan' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    public function attributes(): array
    {
        return [
            'nomor_surat' => 'Nomor Surat',
            'tanggal_surat' => 'Tanggal Surat',
            'tujuan' => 'Tujuan',
            'perihal' => 'Perihal',
            'alamat_penerima' => 'Alamat Penerima',
            'file_surat' => 'File Surat (PDF)',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_surat.unique' => 'Nomor surat sudah terdaftar.',
            'file_surat.mimes' => 'File harus berformat PDF.',
            'file_surat.max' => 'File maksimal 5MB.',
        ];
    }
}