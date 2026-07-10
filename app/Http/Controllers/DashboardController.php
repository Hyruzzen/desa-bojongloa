<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArsip = Arsip::count();
        $totalKategori = Kategori::count();
        $arsipBulanIni = Arsip::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $arsipPerKategori = Kategori::withCount('arsips')->orderByDesc('arsips_count')->get();

        $arsipTerbaru = Arsip::with('kategori')->latest()->take(8)->get();

        return view('dashboard', compact(
            'totalArsip',
            'totalKategori',
            'arsipBulanIni',
            'arsipPerKategori',
            'arsipTerbaru'
        ));
    }
}
