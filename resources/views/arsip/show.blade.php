@extends('layouts.app')
@section('title', 'Detail Arsip')

@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    <div class="flex items-start justify-between mb-6">
        <div>
            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-1 rounded-full mb-2">{{ $arsip->kategori->nama }}</span>
            <h2 class="text-xl font-semibold text-slate-800">{{ $arsip->judul }}</h2>
            <p class="text-sm text-slate-500 mt-1">{{ $arsip->tanggal_arsip->format('d F Y') }} @if($arsip->nomor_arsip) &middot; No. {{ $arsip->nomor_arsip }} @endif</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('arsip.download', $arsip) }}" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg">Unduh File</a>
            <a href="{{ route('arsip.edit', $arsip) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg">Ubah</a>
        </div>
    </div>

    <div class="border-t border-slate-100 pt-4">
        <h3 class="text-sm font-medium text-slate-700 mb-2">Deskripsi / Keterangan</h3>
        <p class="text-sm text-slate-600 whitespace-pre-line">{{ $arsip->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
    </div>

    <div class="border-t border-slate-100 mt-4 pt-4 grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-slate-400">Nama File</p>
            <p class="text-slate-700">{{ $arsip->file_asli ?? '-' }}</p>
        </div>
        <div>
            <p class="text-slate-400">Diunggah Oleh</p>
            <p class="text-slate-700">{{ $arsip->user->name ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('arsip.index') }}" class="text-sm text-slate-500 hover:underline">&larr; Kembali ke daftar arsip</a>
    </div>

    @if($arsip->file_path)
    <div class="mt-8 border-t border-slate-100 pt-6">
        <h3 class="text-sm font-medium text-slate-700 mb-4">Pratinjau Dokumen</h3>
        
        @php
            $ext = strtolower(pathinfo($arsip->file_path, PATHINFO_EXTENSION));
            $fileUrl = asset('storage/' . $arsip->file_path);
        @endphp

        <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden" style="min-height: 500px;">
            @if(in_array($ext, ['pdf']))
                <iframe src="{{ $fileUrl }}" class="w-full h-[600px] border-0"></iframe>
            @elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
                <div class="flex justify-center p-4">
                    <img src="{{ $fileUrl }}" alt="Pratinjau" class="max-w-full h-auto rounded-lg shadow-sm">
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-[300px] text-slate-400">
                    <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm">Pratinjau tidak tersedia untuk format file .{{ $ext }}</p>
                    <a href="{{ route('arsip.download', $arsip) }}" class="mt-3 text-blue-600 hover:underline text-sm font-medium">Unduh Dokumen</a>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
