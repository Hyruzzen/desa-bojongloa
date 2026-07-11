<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private int $timeout;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    /** Menyimpan pesan error terakhir dari API call **/
    private ?string $lastError = null;

    public function __construct()
    {
        $this->apiKey  = config('gemini.api_key', '');
        $this->model   = config('gemini.model', 'gemini-2.0-flash');
        $this->timeout = config('gemini.timeout', 30);
    }

    /** Ambil error terakhir (setelah panggilan analyzeFrom*) **/
    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    /**
     * Apakah API key sudah dikonfigurasi?
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && strlen($this->apiKey) > 20;
    }

    /**
     * Kembalikan pesan error konfigurasi (untuk debugging)
     */
    public function getConfigError(): ?string
    {
        if (empty($this->apiKey)) {
            return 'GEMINI_API_KEY belum diset di .env';
        }
        if (strlen($this->apiKey) < 20) {
            return 'GEMINI_API_KEY terlalu pendek, kemungkinan tidak valid';
        }
        return null;
    }

    /**
     * Analisis dokumen dari teks (hasil ekstrak PDF)
     */
    public function analyzeFromText(string $text): array
    {
        $prompt = $this->buildPrompt($text);

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.1,
            ],
        ];

        return $this->callApi($payload);
    }

    /**
     * Analisis dokumen dari gambar (JPG/PNG) menggunakan Gemini Vision
     */
    public function analyzeFromImage(string $base64Data, string $mimeType): array
    {
        $prompt = $this->buildPrompt('');

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data'      => $base64Data,
                            ],
                        ],
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.1,
            ],
        ];

        return $this->callApi($payload);
    }

    /**
     * Bangun prompt untuk Gemini
     */
    private function buildPrompt(string $text): string
    {
        $context = $text
            ? "Berikut adalah teks yang diekstrak dari dokumen:\n\n---\n{$text}\n---\n\n"
            : "Lihat gambar dokumen yang dilampirkan.\n\n";

        return <<<PROMPT
{$context}Kamu adalah sistem pengarsipan dokumen pemerintahan desa di Indonesia.
Ekstrak informasi berikut dari dokumen ini dan kembalikan dalam format JSON.

Aturan ekstraksi:
- "judul": Judul utama dokumen (biasanya ditulis kapital di bagian atas, contoh: "SURAT KEPUTUSAN KEPALA DESA", "BERITA ACARA MUSYAWARAH"). Jika tidak ada, gunakan null.
- "nomor_arsip": Nomor surat/dokumen (biasanya diawali "Nomor:", "No:", "Nomor Surat:"). Contoh: "001/DS-BJL/I/2025". Jika tidak ada, gunakan null.
- "tanggal_arsip": Tanggal dokumen dalam format YYYY-MM-DD. Contoh: "2025-01-15". Jika tidak ada, gunakan null.
- "kategori": Pilih salah satu kategori yang paling sesuai dari daftar berikut:
    * "Dokumen Kependudukan" (KK, KTP, domisili, kelahiran, kematian, dll)
    * "Keuangan Desa" (APBDes, anggaran, realisasi, keuangan, dll)
    * "Surat Resmi" (surat undangan, instruksi, perintah, pemberitahuan, dll)
    * "Pemerintahan Desa" (peraturan desa, SK kepala desa, musyawarah, dll)
    Jika tidak ada yang cocok, gunakan null.
- "deskripsi": Ringkasan singkat isi dokumen dalam 1-2 kalimat bahasa Indonesia. Jika tidak bisa ditentukan, gunakan null.

Kembalikan HANYA JSON valid tanpa penjelasan tambahan:
{
  "judul": "...",
  "nomor_arsip": "...",
  "tanggal_arsip": "...",
  "kategori": "...",
  "deskripsi": "..."
}
PROMPT;
    }

    /**
     * Kirim request ke Gemini API
     */
    private function callApi(array $payload): array
    {
        $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

        try {
            $response = Http::timeout($this->timeout)
                ->withoutVerifying() // FIX: Bypass SSL local issuer error di environment Windows/XAMPP
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            if ($response->failed()) {
                $body = $response->json();
                $apiStatus  = $body['error']['status'] ?? '';
                $apiMessage = $body['error']['message'] ?? 'HTTP ' . $response->status();

                if ($apiStatus === 'RESOURCE_EXHAUSTED') {
                    $this->lastError = 'quota_exhausted';
                    Log::warning('Gemini API quota exhausted', ['status' => $response->status()]);
                } elseif ($apiStatus === 'PERMISSION_DENIED' || $apiStatus === 'UNAUTHENTICATED') {
                    $this->lastError = 'invalid_key';
                    Log::warning('Gemini API auth error', ['status' => $response->status(), 'msg' => $apiMessage]);
                } else {
                    $this->lastError = 'api_error';
                    Log::warning('Gemini API error', [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                }
                return $this->emptyResult();
            }

            $data = $response->json();

            Log::debug('Gemini API raw response', ['data' => $data]);

            // Ambil teks hasil dari response Gemini
            $rawText = '';
            $parts = $data['candidates'][0]['content']['parts'] ?? [];

            if (is_array($parts)) {
                foreach ($parts as $part) {
                    if (is_array($part) && isset($part['text']) && $part['text'] !== '') {
                        $rawText = (string) $part['text'];
                        break;
                    }
                }
            }

            if (empty($rawText)) {
                Log::warning('Gemini returned empty text', ['data' => $data]);
                return $this->emptyResult();
            }

            // Bersihkan jika ada markdown code fence (```json ... ```)
            $cleaned = trim($rawText);
            $cleaned = preg_replace('/^```json\s*/i', '', $cleaned) ?? $cleaned;
            $cleaned = preg_replace('/^```\s*/i', '', $cleaned) ?? $cleaned;
            $cleaned = preg_replace('/```\s*$/i', '', $cleaned) ?? $cleaned;
            $cleaned = trim($cleaned);

            $result = json_decode($cleaned, true);

            if (!is_array($result)) {
                // Coba cari JSON di dalam teks (kadang Gemini beri teks sebelum JSON)
                if (preg_match('/\{[\s\S]*\}/u', $cleaned, $jsonMatch)) {
                    $result = json_decode($jsonMatch[0], true);
                }
            }

            if (!is_array($result)) {
                Log::warning('Gemini returned invalid JSON', ['raw' => $rawText, 'cleaned' => $cleaned]);
                return $this->emptyResult();
            }

            return [
                'judul'         => isset($result['judul']) && $result['judul'] !== 'null' ? $result['judul'] : null,
                'nomor_arsip'   => isset($result['nomor_arsip']) && $result['nomor_arsip'] !== 'null' ? $result['nomor_arsip'] : null,
                'tanggal_arsip' => isset($result['tanggal_arsip']) && $result['tanggal_arsip'] !== 'null' ? $result['tanggal_arsip'] : null,
                'kategori'      => isset($result['kategori']) && $result['kategori'] !== 'null' ? $result['kategori'] : null,
                'deskripsi'     => isset($result['deskripsi']) && $result['deskripsi'] !== 'null' ? $result['deskripsi'] : null,
            ];

        } catch (Throwable $e) {
            $this->lastError = 'api_error';
            Log::error('Gemini API exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->emptyResult();
        }
    }

    /**
     * Return kosong jika gagal — user isi manual
     */
    private function emptyResult(): array
    {
        return [
            'judul'         => null,
            'nomor_arsip'   => null,
            'tanggal_arsip' => null,
            'kategori'      => null,
            'deskripsi'     => null,
        ];
    }
}
