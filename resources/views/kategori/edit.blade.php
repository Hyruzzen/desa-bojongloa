@extends('layouts.app')
@section('title', 'Ubah Kategori')

@section('content')
<div class="max-w-lg bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    <form method="POST" action="{{ route('kategori.update', $kategori) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
            <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg">Simpan Perubahan</button>
            <a href="{{ route('kategori.index') }}" class="text-slate-500 text-sm px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
