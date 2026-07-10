@extends('layouts.app')
@section('title', 'Kategori Arsip')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kategori..."
            class="rounded-lg border border-slate-300 px-3 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg">Cari</button>
    </form>
    <a href="{{ route('kategori.create') }}" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg text-center">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr class="text-left">
                <th class="py-3 px-4">Nama Kategori</th>
                <th class="py-3 px-4">Deskripsi</th>
                <th class="py-3 px-4">Jumlah Arsip</th>
                <th class="py-3 px-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $kategori)
                <tr class="border-t border-slate-100">
                    <td class="py-3 px-4 font-medium text-slate-800">{{ $kategori->nama }}</td>
                    <td class="py-3 px-4 text-slate-500">{{ $kategori->deskripsi ?: '-' }}</td>
                    <td class="py-3 px-4 text-slate-500">{{ $kategori->arsips_count }}</td>
                    <td class="py-3 px-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('kategori.edit', $kategori) }}" class="text-blue-700 hover:underline">Ubah</a>
                            <form method="POST" action="{{ route('kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-6 text-center text-slate-400">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $kategoris->links() }}</div>
@endsection
