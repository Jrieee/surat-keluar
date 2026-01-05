<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluars';

    protected $fillable = [
        'user_id',
        'nomor_surat',
        'nomor_urut',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'alamat_penerima',
        'file_surat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    /**
     * Relationship: Surat Keluar belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file path for download
     */
    public function getFilePathAttribute()
    {
        return $this->file_surat ? storage_path('app/public/' . $this->file_surat) : null;
    }
}
