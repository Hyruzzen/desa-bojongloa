@extends('layouts.app')
@section('title', 'Data Arsip')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul / nomor / kata kunci..."
            class="md:col-span-2 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="kategori_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
            @endforeach
        </select>
        <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <div class="md:col-span-5 flex items-center gap-2">
            <button 
                class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg">
                Filter
            </button>
                <a href="{{ route('arsip.index') }}" 
                class="text-slate-500 text-sm px-4 py-2">
                Reset
                </a>
               <div class="ml-auto flex gap-2">
               <a href="{{ route('arsip.scan') }}"
                  class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
                   🔍 Scan Dokumen
               </a>

               <a href="{{ route('arsip.create') }}"
                  class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg">
                   + Tambah Arsip
               </a>
        </div>
</div>

    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr class="text-left">
                <th class="py-3 px-4">Judul</th>
                <th class="py-3 px-4">No. Arsip</th>
                <th class="py-3 px-4">Kategori</th>
                <th class="py-3 px-4">Tanggal</th>
                <th class="py-3 px-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($arsips as $arsip)
                <tr class="border-t border-slate-100">
                    <td class="py-3 px-4 font-medium text-slate-800">
                        <a href="{{ route('arsip.show', $arsip) }}" class="hover:text-blue-700">{{ $arsip->judul }}</a>
                    </td>
                    <td class="py-3 px-4 text-slate-500">{{ $arsip->nomor_arsip ?: '-' }}</td>
                    <td class="py-3 px-4">
                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">{{ $arsip->kategori->nama }}</span>
                    </td>
                    <td class="py-3 px-4 text-slate-500">{{ $arsip->tanggal_arsip->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('arsip.download', $arsip) }}" class="text-slate-500 hover:underline">Unduh</a>
                            <a href="{{ route('arsip.edit', $arsip) }}" class="text-blue-700 hover:underline">Ubah</a>
                            <form method="POST" action="{{ route('arsip.destroy', $arsip) }}" onsubmit="return confirm('Hapus arsip ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-6 text-center text-slate-400">Belum ada arsip yang cocok.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $arsips->links() }}</div>
@endsection
