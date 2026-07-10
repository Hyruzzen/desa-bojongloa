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
</div>
@endsection
