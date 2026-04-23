<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Dashboard Admin
            $totalSurat = SuratKeluar::count();
            $totalPegawai = User::where('role', 'pegawai')->count();
            $recentSurats = SuratKeluar::latest()->take(5)->get();
            $allUsers = User::all();

            return view('dashboard.admin', [
                'totalSurat' => $totalSurat,
                'totalPegawai' => $totalPegawai,
                'recentSurats' => $recentSurats,
                'allUsers' => $allUsers,
            ]);
        } else {
            // Dashboard Pegawai
            $recentSurats = $user->suratKeluars()->latest()->take(5)->get();
            $totalSuratUser = $user->suratKeluars()->count();

            return view('dashboard.pegawai', [
                'recentSurats' => $recentSurats,
                'totalSuratUser' => $totalSuratUser,
            ]);
        }
    }
}
