<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Renumber all surat_keluars sequentially from oldest (id ASC)
        $suratKeluars = DB::table('surat_keluars')->orderBy('id', 'asc')->get();
        
        foreach ($suratKeluars as $index => $surat) {
            DB::table('surat_keluars')
                ->where('id', $surat->id)
                ->update(['nomor_urut' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset nomor_urut to null
        DB::table('surat_keluars')->update(['nomor_urut' => null]);
    }
};
