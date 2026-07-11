<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Throwable;

class DocumentScanner
{
    public function __construct(
        private GeminiService $gemini,
        private OcrService $ocr
    ) {}


    /**
     * Scan dokumen dan ekstrak metadata menggunakan Gemini AI.
     * Support: PDF (ekstrak teks) dan gambar (Vision API).
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return array{judul, nomor_arsip, tanggal_arsip, kategori, deskripsi, text}
     */
    public function scan($file): array
    {
        $ext = strtolower($file->getClientOriginalExtension());

        // --- PDF: ekstrak teks dulu, lalu kirim ke Gemini ---
        if ($ext === 'pdf') {
            return $this->scanPdf($file);
        }

        // --- Gambar (JPG/PNG): bisa Gemini Vision atau OCR fallback ---
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return $this->scanImage($file);
        }


        // Format tidak dikenali
        return $this->emptyResult();
    }

    // -------------------------------------------------------------------------

    private function scanPdf($file): array
    {
        $text = '';

        try {
            $parser = new Parser();
            $pdf    = $parser->parseFile($file->getRealPath());
            $text   = $pdf->getText();
        } catch (Throwable $e) {
            // PDF rusak / terenkripsi — lanjut dengan teks kosong
        }

        // Jika Gemini aktif, pakai AI
        if ($this->gemini->isConfigured()) {
            $result         = $this->gemini->analyzeFromText($text);
            $result['text'] = $text;
            return $result;
        }

        // Fallback: regex sederhana jika Gemini tidak dikonfigurasi
        return array_merge(
            $this->legacyExtract($text),
            ['text' => $text]
        );
    }

    private function scanImage($file): array
    {
        // Gemini Vision — encode ke base64
        if ($this->gemini->isConfigured()) {
            $base64   = base64_encode(file_get_contents($file->getRealPath()));
            $mimeType = $file->getMimeType() ?? 'image/jpeg';

            $result         = $this->gemini->analyzeFromImage($base64, $mimeType);
            $result['text'] = '';
            return $result;
        }

        // Fallback jika tanpa Gemini: OCR untuk ekstrak teks dari gambar
        $text = '';
        try {
            $text = $this->ocr->read($file->getRealPath());
        } catch (Throwable $e) {
            $text = '';
        }

        if (!empty($text)) {
            return array_merge(
                $this->legacyExtract($text),
                ['text' => $text]
            );
        }

        return $this->emptyResult();
    }


    // -------------------------------------------------------------------------
    // Fallback regex lama (dipakai jika Gemini tidak dikonfigurasi)
    // -------------------------------------------------------------------------

    private function legacyExtract(string $text): array
    {
        return [
            'judul'         => $this->detectTitle($text),
            'nomor_arsip'   => $this->detectNumber($text),
            'tanggal_arsip' => $this->detectDate($text),
            'kategori'      => $this->detectCategory($text),
            'deskripsi'     => null,
        ];
    }

    private function detectNumber(string $text): ?string
    {
        preg_match('/Nomor\s*[:\-]\s*(.+)/i', $text, $match);
        return isset($match[1]) ? trim($match[1]) : null;
    }

    private function detectDate(string $text): ?string
    {
        $bulan = [
            'januari' => '01', 'februari' => '02', 'maret'    => '03',
            'april'   => '04', 'mei'       => '05', 'juni'     => '06',
            'juli'    => '07', 'agustus'   => '08', 'september'=> '09',
            'oktober' => '10', 'november'  => '11', 'desember' => '12',
        ];

        preg_match(
            '/(\d{1,2})\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+(\d{4})/i',
            $text,
            $match
        );

        if (isset($match[1])) {
            $b = $bulan[strtolower($match[2])] ?? '01';
            return $match[3] . '-' . $b . '-' . str_pad($match[1], 2, '0', STR_PAD_LEFT);
        }

        return null;
    }

    private function detectTitle(string $text): ?string
    {
        $lines = preg_split("/\r\n|\n|\r/", $text);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            if (str_contains(strtoupper($line), 'PEMERINTAH')) continue;
            if (str_contains(strtoupper($line), 'DESA')) continue;
            if (strtoupper($line) === $line && strlen($line) > 5) {
                return $line;
            }
        }
        return null;
    }

    private function detectCategory(string $text): ?string
    {
        $text  = strtolower($text);
        $rules = [
            'Dokumen Kependudukan' => ['kartu keluarga', 'kk', 'nik', 'kependudukan', 'domisili', 'kelahiran', 'kematian'],
            'Keuangan Desa'        => ['apbdes', 'anggaran', 'keuangan', 'realisasi', 'belanja desa'],
            'Surat Resmi'          => ['surat', 'undangan', 'keputusan', 'perintah'],
            'Pemerintahan Desa'    => ['kepala desa', 'peraturan desa', 'perdes', 'musyawarah desa'],
        ];

        foreach ($rules as $kategori => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) return $kategori;
            }
        }

        return null;
    }

    private function emptyResult(): array
    {
        return [
            'judul'         => null,
            'nomor_arsip'   => null,
            'tanggal_arsip' => null,
            'kategori'      => null,
            'deskripsi'     => null,
            'text'          => '',
        ];
    }
}