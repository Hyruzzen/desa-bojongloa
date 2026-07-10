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

            return (new \thiagoalessio\TesseractOCR\TesseractOCR($file))
                ->lang('ind')
                ->run();

        } catch (Throwable $e) {

            // Tesseract tidak terinstall atau gagal dijalankan
            return '';

        }

    }

}