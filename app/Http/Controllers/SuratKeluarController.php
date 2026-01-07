<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Http\Requests\StoreSuratKeluarRequest;
use App\Http\Requests\UpdateSuratKeluarRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $search = request()->input('search');
        
        // Admin melihat semua surat, Staff hanya miliknya
        $query = $user->isAdmin() 
            ? SuratKeluar::with('user')
            : $user->suratKeluars();

        // Filter berdasarkan search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', '%' . $search . '%')
                  ->orWhere('perihal', 'like', '%' . $search . '%')
                  ->orWhere('tujuan', 'like', '%' . $search . '%')
                  ->orWhere('alamat_penerima', 'like', '%' . $search . '%');
            });
        }

        $suratKeluars = $query->orderBy('nomor_urut')->paginate(10);

        return view('surat-keluars.index', [
            'suratKeluars' => $suratKeluars,
            'isAdmin' => $user->isAdmin(),
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surat-keluars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuratKeluarRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        // Auto-generate nomor_urut - surat baru selalu di nomor tertinggi (paling bawah)
        $maxNumber = SuratKeluar::max('nomor_urut') ?? 0;
        $validated['nomor_urut'] = $maxNumber + 1;

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['file_surat'] = $file->storeAs('surat-keluars', $filename, 'public');
        }

        SuratKeluar::create($validated);

        return redirect()->route('surat-keluars.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $this->authorize('view', $suratKeluar);
        return view('surat-keluars.show', ['suratKeluar' => $suratKeluar]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);
        return view('surat-keluars.edit', ['suratKeluar' => $suratKeluar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratKeluarRequest $request, SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);
        
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }

            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['file_surat'] = $file->storeAs('surat-keluars', $filename, 'public');
        }

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluars.show', $suratKeluar)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        $this->authorize('delete', $suratKeluar);

        // Delete file if exists
        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluars.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }

    /**
     * Download the file
     */
    public function download(SuratKeluar $suratKeluar)
    {
        $this->authorize('view', $suratKeluar);

        if (!$suratKeluar->file_surat || !Storage::disk('public')->exists($suratKeluar->file_surat)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($suratKeluar->file_surat);
    }
}
