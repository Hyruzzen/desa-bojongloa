<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;


class OcrService
{

    public function read($file)
    {

        return (new TesseractOCR($file))

            ->lang('ind')

            ->run();

    }

}