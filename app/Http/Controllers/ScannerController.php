<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentScanner;
use App\Services\GeminiService;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Log;


class ScannerController extends Controller
{
    private function normalizeScanResult(array $hasil): array
    {
        // Normalisasi tanggal untuk input <input type="date">
        // Target: format YYYY-MM-DD
        $candidates = [
            'tanggal_arsip',
            'tanggal',
            'date',
            'tgl',
        ];

        $tanggalRaw = null;
        foreach ($candidates as $key) {
            if (!empty($hasil[$key])) {
                $tanggalRaw = $hasil[$key];
                break;
            }
        }

        $tanggalFormatted = null;
        if (!empty($tanggalRaw)) {
            try {
                // Jika sudah YYYY-MM-DD, parse aman
                $timestamp = strtotime((string) $tanggalRaw);

                if ($timestamp !== false && $timestamp > 0) {
                    $tanggalFormatted = date('Y-m-d', $timestamp);

                    // Validasi: strtotime kadang mengembalikan false atau 1970
                    if ($tanggalFormatted === '1970-01-01') {
                        $tanggalFormatted = null;
                    }
                }
            } catch (\Throwable $e) {
                $tanggalFormatted = null;
            }
        }

        if ($tanggalFormatted) {
            $hasil['tanggal_arsip'] = $tanggalFormatted;
        } else {
            $hasil['tanggal_arsip'] = null;
        }

        // Normalisasi kategori (trim)
        if (isset($hasil['kategori']) && is_string($hasil['kategori'])) {
            $hasil['kategori'] = trim($hasil['kategori']);
        }

        // Pastikan key penting tersedia
        $hasil['judul']       = isset($hasil['judul']) && $hasil['judul'] !== '' ? $hasil['judul'] : null;
        $hasil['nomor_arsip'] = isset($hasil['nomor_arsip']) && $hasil['nomor_arsip'] !== '' ? $hasil['nomor_arsip'] : null;
        $hasil['deskripsi']   = isset($hasil['deskripsi']) && $hasil['deskripsi'] !== '' ? $hasil['deskripsi'] : null;
        $hasil['kategori']    = isset($hasil['kategori']) && $hasil['kategori'] !== '' ? $hasil['kategori'] : null;

        return $hasil;
    }


    public function index(GeminiService $gemini)
    {
        return view('arsip.scan', [
            'geminiAktif'  => $gemini->isConfigured(),
            'configError'  => $gemini->getConfigError(),
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
        | Simpan file sementara ke storage/app/public/temp_scan
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
            // Re-fetch file untuk scanner karena file sudah di-move oleh storeAs
            // Kita pakai file asli dari request (masih tersedia sebelum response)
            $hasil = $scanner->scan($request->file('file'));

            // Debug untuk memastikan kenapa hasil kosong
            Log::info('Scan dokumen berhasil diproses', [
                'gemini_configured' => $gemini->isConfigured(),
                'gemini_error'      => $gemini->getConfigError(),
                'file_ext'          => $file->getClientOriginalExtension(),
                'hasil'             => $hasil,
            ]);

        } catch (Throwable $e) {
            Log::error('Scan dokumen gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $hasil = [
                'text'          => '',
                'nomor_arsip'   => null,
                'tanggal_arsip' => null,
                'judul'         => null,
                'kategori'      => null,
                'deskripsi'     => null,
            ];

        }

        $hasil['last_error'] = $gemini->getLastError();

        /*
        |--------------------------------------------------------------------------
        | Tandai apakah hasil dihasilkan oleh AI
        |--------------------------------------------------------------------------
        */

        $hasil['ai_powered'] = $gemini->isConfigured();



        // Normalisasi output agar sesuai format field form arsip

        $hasil = $this->normalizeScanResult($hasil);

        $hasil['file_path'] = $filePath;

        /*
        |--------------------------------------------------------------------------
        | Cari kategori_id berdasarkan nama kategori
        |--------------------------------------------------------------------------
        */

        $kategoriId = null;

        if (!empty($hasil['kategori'])) {
            $kategoriModel = Kategori::where(
                'nama', 'like', '%' . $hasil['kategori'] . '%'
            )->first();

            $kategoriId = $kategoriModel?->id;
        }

        $hasil['kategori_id'] = $kategoriId;


        /*
        |--------------------------------------------------------------------------
        | Simpan hasil scan ke session lalu redirect ke form create
        |--------------------------------------------------------------------------
        */

        // Pastikan session di-flush dulu sebelum isi baru
        session()->forget('hasil_scan');
        session()->put('hasil_scan', $hasil);
        session()->save();

        Log::info('Session hasil_scan disimpan', [
            'kategori_id' => $hasil['kategori_id'],
            'judul'       => $hasil['judul'],
        ]);

        return redirect()->route('arsip.create');

    }

}