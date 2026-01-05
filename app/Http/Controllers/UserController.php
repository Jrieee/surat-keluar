<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::latest()->paginate(10);
        
        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return view('users.show', ['user' => $user]);
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
