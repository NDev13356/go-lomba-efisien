<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Get voting results as JSON
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function rekap()
    {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        $totalSuara = Pemilihan::count();

        $result = $kandidat->map(function ($item) use ($totalSuara) {
            return [
                'nama_kandidat' => $item->nama,
                'jumlah_suara' => $item->jumlah_suara,
                'persentase' => $totalSuara > 0 
                    ? round(($item->jumlah_suara / $totalSuara) * 100, 2) 
                    : 0.0,
            ];
        });

        return response()->json($result);
    }
}
