<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->text('alamat_penerima');
            $table->string('file_surat')->nullable();
            $table->timestamps();

            $table->index('nomor_surat');
            $table->index('tanggal_surat');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
