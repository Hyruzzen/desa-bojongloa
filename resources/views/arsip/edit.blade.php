@extends('layouts.app')
@section('title', 'Ubah Arsip')

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    <form method="POST" action="{{ route('arsip.update', $arsip) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Arsip</label>
                <input type="text" name="judul" value="{{ old('judul', $arsip->judul) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('kategori_id', $arsip->kategori_id) == $kategori->id)>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Arsip (opsional)</label>
                <input type="text" name="nomor_arsip" value="{{ old('nomor_arsip', $arsip->nomor_arsip) }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Arsip</label>
                <input type="date" name="tanggal_arsip" value="{{ old('tanggal_arsip', $arsip->tanggal_arsip->format('Y-m-d')) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ganti File (opsional)</label>
                <input type="file" name="file"
                    class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-sm">
                <p class="text-xs text-slate-400 mt-1">File saat ini: {{ $arsip->file_asli }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi / Keterangan (opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $arsip->deskripsi) }}</textarea>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg">Simpan Perubahan</button>
            <a href="{{ route('arsip.index') }}" class="text-slate-500 text-sm px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
