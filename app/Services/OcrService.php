<?php

namespace App\Services;

use Throwable;


class OcrService
{

    public function read($file): string
    {
        // Cek apakah library Tesseract OCR tersedia
        if (!class_exists(\thiagoalessio\TesseractOCR\TesseractOCR::class)) {
            return '';
        }

        try {
            $ocr = new \thiagoalessio\TesseractOCR\TesseractOCR($file);

            // Auto-detect Tesseract binary on Windows if not in PATH
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $commonPaths = [
                    'C:\\Program Files\\Tesseract-OCR\\tesseract.exe',
                    'C:\\Program Files (x86)\\Tesseract-OCR\\tesseract.exe',
                ];
                foreach ($commonPaths as $path) {
                    if (file_exists($path)) {
                        $ocr->executable($path);
                        break;
                    }
                }
            }

            return $ocr->lang('ind')->run();

        } catch (Throwable $e) {
            // Tesseract tidak terinstall atau gagal dijalankan
            return '';
        }
    }

}