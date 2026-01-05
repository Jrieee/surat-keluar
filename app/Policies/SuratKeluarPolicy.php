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
        return $user->isAdmin() || $user->id === $suratKeluar->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Both admin and staff can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuratKeluar $suratKeluar): bool
    {
        return $user->isAdmin() || $user->id === $suratKeluar->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuratKeluar $suratKeluar): bool
    {
        return $user->isAdmin() || $user->id === $suratKeluar->user_id;
    }
}
