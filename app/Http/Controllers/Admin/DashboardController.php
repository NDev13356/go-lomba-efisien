<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use App\Models\Siswa;

class DashboardController extends Controller
{
    /**
     * Admin dashboard with voting summary
     */
    public function index()
    {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        $totalSuara = Pemilihan::count();
        $totalSiswa = Siswa::count();
        $totalKandidat = Kandidat::count();

        // Calculate percentages
        $kandidat->transform(function ($item) use ($totalSuara) {
            $item->persentase = $totalSuara > 0 
                ? round(($item->jumlah_suara / $totalSuara) * 100, 2) 
                : 0;
            return $item;
        });

        return view('admin.dashboard', compact('kandidat', 'totalSuara', 'totalSiswa', 'totalKandidat'));
    }
}
