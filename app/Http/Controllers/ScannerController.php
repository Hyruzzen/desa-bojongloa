<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DocumentScanner;
use App\Models\Kategori;
use Illuminate\Support\Str;

class ScannerController extends Controller
{

    public function index()
    {
        return view('arsip.scan');
    }



    public function scan(
        Request $request,
        DocumentScanner $scanner
    )
    {

        $request->validate([

            'file'=>'required|file|max:10240'

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
    .'-'
    .time()
    .'.'
    .$file->getClientOriginalExtension();



$filePath =
    $file->storeAs(
        'temp_scan',
        $namaFile,
        'public'
    );



        /*
        |--------------------------------------------------------------------------
        | Baca metadata dokumen
        |--------------------------------------------------------------------------
        */

        $hasil = 
            $scanner->scan(
                $request->file('file')
            );



        /*
        |--------------------------------------------------------------------------
        | Simpan lokasi file
        |--------------------------------------------------------------------------
        */

        $hasil['file_path'] = $filePath;



        /*
        |--------------------------------------------------------------------------
        | Cari kategori berdasarkan hasil scan
        |--------------------------------------------------------------------------
        */

        $kategori = null;


        if(
            !empty($hasil['kategori'])
        )
        {

            $kategori =
                Kategori::where(
                    'nama',
                    'like',
                    '%'.$hasil['kategori'].'%'
                )->first();

        }



        $hasil['kategori_id'] =
            $kategori?->id;



        /*
        |--------------------------------------------------------------------------
        | Simpan hasil scan sementara
        |--------------------------------------------------------------------------
        */

        session([
            'hasil_scan'=>$hasil
        ]);



        return redirect()
            ->route('arsip.create');

    }

}