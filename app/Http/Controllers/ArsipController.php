<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ArsipController extends Controller
{

    public function index(Request $request)
    {
        $arsips = Arsip::with('kategori')
            ->when($request->q, function ($query) use ($request) {

                $query->where(function ($sub) use ($request) {

                    $sub->where('judul', 'like', "%{$request->q}%")
                        ->orWhere('nomor_arsip', 'like', "%{$request->q}%")
                        ->orWhere('deskripsi', 'like', "%{$request->q}%");

                });

            })
            ->when(
                $request->kategori_id,
                fn($q) => $q->where(
                    'kategori_id',
                    $request->kategori_id
                )
            )
            ->when(
                $request->dari,
                fn($q) => $q->whereDate(
                    'tanggal_arsip',
                    '>=',
                    $request->dari
                )
            )
            ->when(
                $request->sampai,
                fn($q) => $q->whereDate(
                    'tanggal_arsip',
                    '<=',
                    $request->sampai
                )
            )
            ->latest('tanggal_arsip')
            ->paginate(10)
            ->withQueryString();


        $kategoris = Kategori::orderBy('nama')->get();


        return view('arsip.index', compact(
            'arsips',
            'kategoris'
        ));
    }




    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        $hasilScan = session()->get('hasil_scan');


        return view('arsip.create', compact(
            'kategoris',
            'hasilScan'
        ));
    }




    public function store(Request $request)
    {

        $data = $request->validate([

            'kategori_id'
                => 'required|exists:kategoris,id',

            'judul'
                => 'required|string|max:255',

            'nomor_arsip'
                => 'nullable|string|max:255',

            'tanggal_arsip'
                => 'required|date',

            'deskripsi'
                => 'nullable|string',

            'file'
                => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',

        ]);



        $path = null;

        $namaAsli = null;




        // Upload manual

        if($request->hasFile('file'))
        {

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



            $path =
                $file->storeAs(
                    'arsip',
                    $namaFile,
                    'public'
                );


            $namaAsli =
                $file->getClientOriginalName();

        }




        // File hasil scan

        elseif(session()->has('hasil_scan.file_path'))
        {

            $tempPath =
                session('hasil_scan.file_path');


            $namaFile =
                basename($tempPath);



            $pathBaru =
                'arsip/'.$namaFile;



            Storage::disk('public')
                ->move(
                    $tempPath,
                    $pathBaru
                );



            $path =
                $pathBaru;


            $namaAsli =
                $namaFile;

        }



        else
        {

            return back()
                ->withErrors([
                    'file'=>'File dokumen belum tersedia.'
                ]);

        }




        Arsip::create([

            'kategori_id'
                => $data['kategori_id'],

            'judul'
                => $data['judul'],

            'nomor_arsip'
                => $data['nomor_arsip'] ?? null,

            'tanggal_arsip'
                => $data['tanggal_arsip'],

            'deskripsi'
                => $data['deskripsi'] ?? null,

            'file_path'
                => $path,

            'file_asli'
                => $namaAsli,

            'user_id'
                => $request->user()->id,

        ]);



        session()->forget('hasil_scan');



        return redirect()
            ->route('arsip.index')
            ->with(
                'success',
                'Arsip berhasil ditambahkan.'
            );

    }






    public function show(Arsip $arsip)
    {

        $arsip->load(
            'kategori',
            'user'
        );


        return view(
            'arsip.show',
            compact('arsip')
        );

    }





    public function edit(Arsip $arsip)
    {

        $kategoris =
            Kategori::orderBy('nama')->get();


        return view(
            'arsip.edit',
            compact(
                'arsip',
                'kategoris'
            )
        );

    }






    public function update(Request $request, Arsip $arsip)
    {

        $data = $request->validate([

            'kategori_id'
                => 'required|exists:kategoris,id',

            'judul'
                => 'required|string|max:255',

            'nomor_arsip'
                => 'nullable|string|max:255',

            'tanggal_arsip'
                => 'required|date',

            'deskripsi'
                => 'nullable|string',

            'file'
                => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',

        ]);




        if($request->hasFile('file'))
        {


            if($arsip->file_path)
            {

                Storage::disk('public')
                    ->delete(
                        $arsip->file_path
                    );

            }




            $file =
                $request->file('file');



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



            $data['file_path'] =
                $file->storeAs(
                    'arsip',
                    $namaFile,
                    'public'
                );



            $data['file_asli'] =
                $file->getClientOriginalName();

        }



        $arsip->update($data);



        return redirect()
            ->route('arsip.index')
            ->with(
                'success',
                'Arsip berhasil diperbarui.'
            );

    }






    public function destroy(Arsip $arsip)
    {

        if($arsip->file_path)
        {

            Storage::disk('public')
                ->delete(
                    $arsip->file_path
                );

        }


        $arsip->delete();



        return back()
            ->with(
                'success',
                'Arsip berhasil dihapus.'
            );

    }






    public function download(Arsip $arsip)
    {

        abort_unless(
            Storage::disk('public')
                ->exists(
                    $arsip->file_path
                ),
            404
        );


        return Storage::disk('public')
            ->download(
                $arsip->file_path,
                $arsip->file_asli 
                    ?? basename($arsip->file_path)
            );

    }

}