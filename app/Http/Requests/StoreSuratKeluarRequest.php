<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratKeluarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nomor_surat' => 'required|string|unique:surat_keluars,nomor_surat|max:50',
            'tanggal_surat' => 'required|date|date_format:Y-m-d',
            'tujuan' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
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

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'nomor_surat.unique' => 'Nomor surat sudah terdaftar.',
            'file_surat.mimes' => 'File harus berformat PDF.',
            'file_surat.max' => 'File maksimal 5MB.',
        ];
    }
}
