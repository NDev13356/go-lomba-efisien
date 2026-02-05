<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List all admins
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.admin.index', compact('admins'));
    }

    /**
     * Show create admin form
     */
    public function create()
    {
        return view('admin.admin.form', ['admin' => null]);
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Show edit admin form
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admin.form', compact('admin'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admin,username,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->username = $request->username;
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Delete admin
     */
    public function destroy($id)
    {
        // Prevent deleting self
        if (session('admin_id') == $id) {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        Admin::findOrFail($id)->delete();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
