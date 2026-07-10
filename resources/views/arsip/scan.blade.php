@extends('layouts.app')


@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">


        <h2 class="text-xl font-semibold text-slate-800 mb-2">
            🔍 Scan Dokumen Arsip
        </h2>


        <p class="text-sm text-slate-500 mb-6">
            Upload dokumen untuk membaca nomor arsip,
            judul, tanggal, dan kategori secara otomatis.
        </p>


        @if(session('success'))

            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>

        @endif



        <form method="POST"
              action="{{ route('arsip.scan.process') }}"
              enctype="multipart/form-data">

            @csrf


            <label class="block text-sm font-medium mb-2">
                Pilih Dokumen
            </label>


            <input type="file"
                   name="file"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border rounded-lg px-3 py-2">


            <p class="text-xs text-slate-400 mt-2">
                Maksimal 10 MB.
                Format PDF, JPG, PNG.
            </p>


            <button
                class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium">

                Mulai Scan

            </button>


        </form>


    </div>

</div>


@endsection