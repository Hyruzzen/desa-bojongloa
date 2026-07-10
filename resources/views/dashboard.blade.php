@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6">
    <div class="grid gap-4 grid-cols-1 xl:grid-cols-3">
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Arsip</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($totalArsip) }}</p>
            <p class="mt-4 text-sm text-slate-500">Semua arsip yang tersimpan di sistem.</p>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Kategori</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($totalKategori) }}</p>
            <p class="mt-4 text-sm text-slate-500">Kategori dokumen yang tersedia.</p>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Arsip Bulan Ini</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($arsipBulanIni) }}</p>
            <p class="mt-4 text-sm text-slate-500">Jumlah arsip yang dibuat di bulan ini.</p>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-3">
        <section class="xl:col-span-2 space-y-4">
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Ringkasan Arsip</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Aktivitas Terbaru</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="relative">
                            <input type="text" placeholder="Cari arsip..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-slate-300 focus:outline-none" />
                            <button type="button" class="absolute inset-y-0 right-2 inline-flex items-center rounded-xl bg-slate-900 px-4 text-sm font-semibold text-white hover:bg-slate-800">Cari</button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    @foreach($arsipPerKategori->take(3) as $kategori)
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">{{ $kategori->nama }}</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $kategori->arsips_count }}</p>
                            <p class="mt-2 text-xs text-slate-400">Arsip dalam kategori ini</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Arsip Terbaru</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Daftar terbaru</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600">{{ now()->translatedFormat('F Y') }}</span>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse($arsipTerbaru as $arsip)
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $arsip->judul ?? 'Judul belum tersedia' }}</p>
                                    <p class="mt-1 text-sm text-slate-500">Kategori: {{ $arsip->kategori->nama ?? 'Tidak diketahui' }}</p>
                                </div>
                                <p class="text-xs text-slate-400">{{ $arsip->tanggal_arsip?->translatedFormat('d M Y') ?? $arsip->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-500">
                            Belum ada arsip terbaru.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <aside class="space-y-4">
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kategori Teratas</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Berdasarkan jumlah arsip</h2>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach($arsipPerKategori->take(5) as $kategori)
                        <div class="flex items-center justify-between rounded-3xl border border-slate-100 bg-slate-50 px-4 py-3">
                            <div>
                                <p class="font-medium text-slate-900">{{ $kategori->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $kategori->arsips_count }} arsip</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $kategori->arsips_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Statistik Cepat</p>
                <div class="mt-5 grid gap-3">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Rata-rata arsip per kategori</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalKategori ? number_format($totalArsip / $totalKategori, 1) : 0 }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Data kategori</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($totalKategori) }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
