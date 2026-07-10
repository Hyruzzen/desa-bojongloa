@extends('layouts.app')
@section('title', 'Tambah Arsip')

@section('content')

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-slate-100 p-6">

    @if(isset($hasilScan))

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-5">

            <h3 class="font-semibold text-green-700 mb-2">
                ✅ Hasil Scan Dokumen
            </h3>

            <p class="text-sm text-green-600">
                Sistem berhasil membaca dokumen.
                Silakan periksa kembali sebelum menyimpan.
            </p>

        </div>

    @endif


    <form method="POST" 
          action="{{ route('arsip.store') }}" 
          enctype="multipart/form-data" 
          class="space-y-4">

        @csrf


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


            {{-- Judul --}}
            <div class="md:col-span-2">

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Judul Arsip
                </label>


                <input type="text"
                    name="judul"

                    value="{{ old('judul', $hasilScan['judul'] ?? '') }}"

                    required

                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>



            {{-- Kategori --}}
            <div>

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Kategori
                </label>


                <select name="kategori_id"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">


                    <option value="">
                        -- Pilih Kategori --
                    </option>


                    @foreach ($kategoris as $kategori)

                        <option value="{{ $kategori->id }}"

                            @selected(
                                old(
                                    'kategori_id',
                                    $hasilScan['kategori_id'] ?? ''
                                )
                                == $kategori->id
                            )

                        >

                            {{ $kategori->nama }}

                        </option>


                    @endforeach


                </select>

            </div>



            {{-- Nomor Arsip --}}
            <div>

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nomor Arsip (opsional)
                </label>


                <input type="text"
                    name="nomor_arsip"

                    value="{{ old('nomor_arsip', $hasilScan['nomor_arsip'] ?? '') }}"

                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>



            {{-- Tanggal --}}
            <div>

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tanggal Arsip
                </label>


                <input type="date"
                    name="tanggal_arsip"

                    value="{{ old('tanggal_arsip', $hasilScan['tanggal_arsip'] ?? '') }}"

                    required

                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>




            {{-- File --}}
            <div>

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    File Dokumen
                </label>


                @if(isset($hasilScan['file_path']))

    <div class="bg-green-50 border border-green-200 rounded-lg p-3">

        <p class="text-sm text-green-700 font-medium">
            ✅ File hasil scan sudah siap
        </p>

        <p class="text-xs text-green-600 mt-1">
            {{ basename($hasilScan['file_path']) }}
        </p>

    </div>

@else

    <input type="file"
        name="file"
        required
        class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-sm">

@endif

                <p class="text-xs text-slate-400 mt-1">
                    PDF, gambar, atau dokumen Office, maks. 10MB.
                </p>


            </div>




            {{-- Deskripsi --}}
            <div class="md:col-span-2">


                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Deskripsi / Keterangan (opsional)
                </label>


                <textarea
                    name="deskripsi"
                    rows="3"

                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $hasilScan['deskripsi'] ?? '') }}</textarea>


            </div>



        </div>



        <div class="flex gap-3 pt-2">


            <button

                class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg">

                Simpan Arsip

            </button>



            <a href="{{ route('arsip.index') }}"

               class="text-slate-500 text-sm px-4 py-2">

                Batal

            </a>


        </div>



    </form>

</div>


@endsection