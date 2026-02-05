<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // If already logged in, redirect to voting page
        if (session()->has('siswa_nisn')) {
            return redirect()->route('siswa.voting');
        }
        return view('siswa.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string',
        ]);

        $siswa = Siswa::find($request->nisn);

        if (!$siswa || !Hash::check($request->password, $siswa->password)) {
            return back()->withErrors(['login' => 'NISN atau password salah.'])->withInput();
        }

        // Store siswa data in session
        session([
            'siswa_nisn' => $siswa->nisn,
            'siswa_nama' => $siswa->nama,
        ]);

        return redirect()->route('siswa.voting');
    }

    /**
     * Logout siswa
     */
    public function logout()
    {
        session()->forget(['siswa_nisn', 'siswa_nama']);
        return redirect()->route('siswa.login');
    }
}
