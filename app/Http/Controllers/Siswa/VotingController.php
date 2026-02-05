<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    /**
     * Show voting page
     */
    public function showVoting()
    {
        $siswa = Siswa::find(session('siswa_nisn'));
        
        // Check if already voted
        if ($siswa->hasVoted()) {
            $vote = $siswa->pemilihan()->with('kandidat')->first();
            return view('siswa.sudah-memilih', compact('siswa', 'vote'));
        }

        $kandidat = Kandidat::all();
        return view('siswa.voting', compact('siswa', 'kandidat'));
    }

    /**
     * Process vote
     */
    public function vote(Request $request)
    {
        $request->validate([
            'id_kandidat' => 'required|exists:kandidat,id_kandidat',
        ]);

        $siswa = Siswa::find(session('siswa_nisn'));

        // Check if already voted
        if ($siswa->hasVoted()) {
            return redirect()->route('siswa.voting')
                ->withErrors(['vote' => 'Anda sudah memilih dan tidak bisa memilih lagi.']);
        }

        // Create vote record
        Pemilihan::create([
            'id_kandidat' => $request->id_kandidat,
            'nisn' => $siswa->nisn,
        ]);

        return redirect()->route('siswa.voting')
            ->with('success', 'Terima kasih! Suara Anda telah tercatat.');
    }
}
