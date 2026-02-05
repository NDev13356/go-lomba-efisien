<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    /**
     * List all kandidat
     */
    public function index()
    {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        return view('admin.kandidat.index', compact('kandidat'));
    }

    /**
     * Show create kandidat form
     */
    public function create()
    {
        return view('admin.kandidat.form', ['kandidat' => null]);
    }

    /**
     * Store new kandidat
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = ['nama' => $request->nama];

        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            Storage::disk('public')->putFileAs('kandidat', $request->file('foto'), $filename);
            $data['foto'] = $filename;
        }

        Kandidat::create($data);

        return redirect()->route('admin.kandidat.index')
            ->with('success', 'Kandidat berhasil ditambahkan.');
    }

    /**
     * Show edit kandidat form
     */
    public function edit($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        return view('admin.kandidat.form', compact('kandidat'));
    }

    /**
     * Update kandidat
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kandidat = Kandidat::findOrFail($id);
        $kandidat->nama = $request->nama;

        if ($request->hasFile('foto')) {
            if ($kandidat->foto) {
                Storage::disk('public')->delete('kandidat/' . $kandidat->foto);
            }
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            Storage::disk('public')->putFileAs('kandidat', $request->file('foto'), $filename);
            $kandidat->foto = $filename;
        }

        $kandidat->save();

        return redirect()->route('admin.kandidat.index')
            ->with('success', 'Kandidat berhasil diperbarui.');
    }

    /**
     * Delete kandidat
     */
    public function destroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        
        if ($kandidat->foto) {
            Storage::disk('public')->delete('kandidat/' . $kandidat->foto);
        }

        $kandidat->delete();

        return redirect()->route('admin.kandidat.index')
            ->with('success', 'Kandidat berhasil dihapus.');
    }
}
