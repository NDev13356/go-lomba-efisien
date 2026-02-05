<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * List all siswa
     */
    public function index()
    {
        $siswa = Siswa::with('pemilihan.kandidat')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show create siswa form
     */
    public function create()
    {
        return view('admin.siswa.form', ['siswa' => null]);
    }

    /**
     * Store new siswa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:siswa,nisn',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        Siswa::create([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Show edit siswa form
     */
    public function edit($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        return view('admin.siswa.form', compact('siswa'));
    }

    /**
     * Update siswa
     */
    public function update(Request $request, $nisn)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $siswa = Siswa::findOrFail($nisn);
        $siswa->nama = $request->nama;
        
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Delete siswa
     */
    public function destroy($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }
}
