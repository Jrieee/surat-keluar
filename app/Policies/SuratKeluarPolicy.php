<?php

namespace App\Policies;

use App\Models\SuratKeluar;
use App\Models\User;

class SuratKeluarPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SuratKeluar $suratKeluar): bool
    {
        // Semua user yang authenticated bisa view surat
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin(); // Only admin can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuratKeluar $suratKeluar): bool
    {
        return $user->isAdmin(); // Only admin can update
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuratKeluar $suratKeluar): bool
    {
        return $user->isAdmin(); // Only admin can delete
    }
}
