<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Carbon\Carbon;


class DocumentScanner
{

    public function scan($file)
    {

        $text = "";


        if (
            strtolower($file->getClientOriginalExtension()) == 'pdf'
        ) {

            $parser = new Parser();

            $pdf = $parser->parseFile(
                $file->getRealPath()
            );

            $text = $pdf->getText();

        }


        return [

    'text' => $text,

    'nomor_arsip' =>
        $this->detectNumber($text),

    'tanggal_arsip' =>
        $this->detectDate($text),

    'judul' =>
        $this->detectTitle($text),

    'kategori' =>
        $this->detectCategory($text),

];

    }



    /*
    |--------------------------------------------------------------------------
    | Deteksi Nomor Arsip
    |--------------------------------------------------------------------------
    */

    private function detectNumber($text)
    {

        preg_match(
            '/Nomor\s*[:\-]\s*(.+)/i',
            $text,
            $match
        );


        return isset($match[1])
            ? trim($match[1])
            : null;

    }




    /*
    |--------------------------------------------------------------------------
    | Deteksi Tanggal
    |--------------------------------------------------------------------------
    */

    private function detectDate($text)
    {

        $bulan = [
            'Januari'=>'01',
            'Februari'=>'02',
            'Maret'=>'03',
            'April'=>'04',
            'Mei'=>'05',
            'Juni'=>'06',
            'Juli'=>'07',
            'Agustus'=>'08',
            'September'=>'09',
            'Oktober'=>'10',
            'November'=>'11',
            'Desember'=>'12'
        ];


        preg_match(
            '/(\d{1,2})\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+(\d{4})/i',
            $text,
            $match
        );


        if(isset($match[1]))
        {

            $tanggal = str_pad(
                $match[1],
                2,
                '0',
                STR_PAD_LEFT
            );


            $bulanAngka =
                $bulan[$match[2]];


            $tahun =
                $match[3];


            return $tahun
                .'-'
                .$bulanAngka
                .'-'
                .$tanggal;

        }


        return null;

    }





    /*
    |--------------------------------------------------------------------------
    | Deteksi Judul Dokumen
    |--------------------------------------------------------------------------
    */

    private function detectTitle($text)
    {

        $lines = preg_split(
            "/\r\n|\n|\r/",
            $text
        );


        foreach($lines as $line)
        {

            $line = trim($line);


            if(empty($line))
                continue;


            // abaikan header umum
            if(
                str_contains(
                    strtoupper($line),
                    'PEMERINTAH'
                )
            )
                continue;


            if(
                str_contains(
                    strtoupper($line),
                    'DESA'
                )
            )
                continue;



            // ambil tulisan kapital yang kemungkinan judul

            if(
                strtoupper($line)
                ==
                $line
            )
            {

                if(
                    strlen($line) > 5
                )
                {
                    return $line;
                }

            }

        }


        return null;

    }

private function detectCategory($text)
{

    $text = strtolower($text);



    $rules = [

        'Dokumen Kependudukan' => [

            'kartu keluarga',
            'kk',
            'nik',
            'kependudukan',
            'domisili',
            'kelahiran',
            'kematian'

        ],


        'Keuangan Desa' => [

            'apbdes',
            'anggaran',
            'keuangan',
            'realisasi',
            'belanja desa'

        ],



        'Surat Resmi' => [

            'surat',
            'undangan',
            'keputusan',
            'perintah'

        ],



        'Pemerintahan Desa' => [

            'kepala desa',
            'peraturan desa',
            'perdes',
            'musyawarah desa'

        ],

    ];



    foreach($rules as $kategori=>$keywords)
    {

        foreach($keywords as $keyword)
        {

            if(str_contains($text,$keyword))
            {
                return $kategori;
            }

        }

    }



    return null;

}



}