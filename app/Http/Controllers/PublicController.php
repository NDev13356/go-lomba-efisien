<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display public voting results with pie chart
     */
    public function index()
    {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        $totalSuara = Pemilihan::count();
        
        // Calculate percentages
        $kandidat->transform(function ($item) use ($totalSuara) {
            $item->persentase = $totalSuara > 0 
                ? round(($item->jumlah_suara / $totalSuara) * 100, 2) 
                : 0;
            return $item;
        });

        return view('public.index', compact('kandidat', 'totalSuara'));
    }

    /**
     * REST API: Get all kandidat
     */
    public function apiKandidat()
    {
        $kandidat = Kandidat::select('id_kandidat', 'nama', 'foto')->get();

        return response()->json([
            'success' => true,
            'data' => $kandidat
        ]);
    }

    /**
     * REST API: Get voting results
     */
    public function apiHasil()
    {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')
            ->select('id_kandidat', 'nama', 'foto')
            ->get();
        $totalSuara = Pemilihan::count();

        // Calculate percentages
        $kandidat->transform(function ($item) use ($totalSuara) {
            $item->persentase = $totalSuara > 0 
                ? round(($item->jumlah_suara / $totalSuara) * 100, 2) 
                : 0;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $kandidat,
            'total_suara' => $totalSuara
        ]);
    }

    /**
     * Display API documentation page
     */
    public function apiDocs()
    {
        return view('public.api-docs');
    }
}
