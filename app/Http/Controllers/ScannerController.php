<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentScanner;
use App\Services\GeminiService;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Throwable;

class ScannerController extends Controller
{

    public function index(GeminiService $gemini)
    {
        return view('arsip.scan', [
            'geminiAktif' => $gemini->isConfigured(),
        ]);
    }


    public function scan(
        Request $request,
        DocumentScanner $scanner,
        GeminiService $gemini
    ) {

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan file sementara
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $namaFile =
            Str::slug(
                pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            )
            . '-'
            . time()
            . '.'
            . $file->getClientOriginalExtension();

        $filePath =
            $file->storeAs(
                'temp_scan',
                $namaFile,
                'public'
            );


        /*
        |--------------------------------------------------------------------------
        | Scan dokumen dengan Gemini AI (atau fallback regex)
        |--------------------------------------------------------------------------
        */

        try {

            $hasil = $scanner->scan($request->file('file'));

        } catch (Throwable $e) {

            $hasil = [
                'text'          => '',
                'nomor_arsip'   => null,
                'tanggal_arsip' => null,
                'judul'         => null,
                'kategori'      => null,
                'deskripsi'     => null,
            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Tandai apakah hasil dihasilkan oleh AI
        |--------------------------------------------------------------------------
        */

        $hasil['ai_powered'] = $gemini->isConfigured();
        $hasil['file_path']  = $filePath;


        /*
        |--------------------------------------------------------------------------
        | Cari kategori_id berdasarkan nama kategori
        |--------------------------------------------------------------------------
        */

        $kategori = null;

        if (!empty($hasil['kategori'])) {
            $kategori = Kategori::where(
                'nama', 'like', '%' . $hasil['kategori'] . '%'
            )->first();
        }

        $hasil['kategori_id'] = $kategori?->id;


        /*
        |--------------------------------------------------------------------------
        | Simpan hasil scan ke session
        |--------------------------------------------------------------------------
        */

        session(['hasil_scan' => $hasil]);


        return redirect()->route('arsip.create');

    }

}