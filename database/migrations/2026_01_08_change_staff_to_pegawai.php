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
        // Update role values from 'staff' to 'pegawai'
        DB::table('users')->where('role', 'staff')->update(['role' => 'pegawai']);

        // Change the enum type
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pegawai'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to 'staff'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->change();
        });

        // Revert role values from 'pegawai' to 'staff'
        DB::table('users')->where('role', 'pegawai')->update(['role' => 'staff']);
    }
};
