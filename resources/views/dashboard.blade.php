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

    <div class="mt-6 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition-colors dark:border-slate-700 dark:bg-slate-800">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Distribusi Dokumen</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900 dark:text-slate-100">Jumlah dokumen per kategori</h2>
            </div>
            <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-cyan-700 dark:bg-cyan-500/10 dark:text-cyan-300">Bar Chart</span>
        </div>

        <div id="documentCategoryChartWrapper" class="mt-6 h-[320px] overflow-hidden rounded-3xl bg-white dark:bg-slate-900">
            <canvas id="documentCategoryChart" class="w-full h-full" style="display: block; background-color: transparent;"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('documentCategoryChart');
        if (!canvas || typeof Chart === 'undefined') return;

        const labels = @json($arsipPerKategori->pluck('nama')->all());
        const values = @json($arsipPerKategori->pluck('arsips_count')->all());

        const palette = [
            { bg: 'rgba(59, 130, 246, 0.85)', border: '#3b82f6' },
            { bg: 'rgba(16, 185, 129, 0.85)', border: '#10b981' },
            { bg: 'rgba(168, 85, 247, 0.85)', border: '#a855f7' },
            { bg: 'rgba(249, 115, 22, 0.85)', border: '#f97316' },
            { bg: 'rgba(244, 114, 182, 0.85)', border: '#ec4899' },
            { bg: 'rgba(14, 165, 233, 0.85)', border: '#0ea5e9' },
            { bg: 'rgba(239, 68, 68, 0.85)', border: '#ef4444' },
        ];

        const getThemeColors = () => {
            const isDark = document.documentElement.classList.contains('dark');

            return {
                text: isDark ? '#f8fafc' : '#0f172a',
                grid: isDark ? 'rgba(255,255,255,0.12)' : 'rgba(15,23,42,0.08)',
                border: isDark ? '#475569' : '#cbd5e1',
                tooltipBg: isDark ? 'rgba(15,23,42,0.95)' : 'rgba(255,255,255,0.97)',
                tooltipText: isDark ? '#f8fafc' : '#0f172a',
                canvasBg: isDark ? '#0f172a' : '#ffffff',
                wrapperBg: isDark ? '#0f172a' : '#ffffff',
            };
        };

        const wrapper = document.getElementById('documentCategoryChartWrapper');

        const chartBackgroundPlugin = {
            id: 'chartBackground',
            beforeDraw(chart) {
                const ctx = chart.ctx;
                const canvasBg = chart.options.plugins.chartBackground?.backgroundColor;
                if (!canvasBg) return;

                ctx.save();
                ctx.fillStyle = canvasBg;
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            },
        };

        const chart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: values,
                    backgroundColor: labels.map((_, index) => palette[index % palette.length].bg),
                    borderColor: labels.map((_, index) => palette[index % palette.length].border),
                    borderWidth: 1.5,
                    borderRadius: 8,
                    maxBarThickness: 44,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    chartBackground: {
                        backgroundColor: getThemeColors().canvasBg,
                    },
                    legend: {
                        labels: {
                            color: getThemeColors().text,
                            boxWidth: 12,
                            padding: 16,
                            font: { family: 'Inter, ui-sans-serif, system-ui', size: 13, weight: '600' },
                        },
                    },
                    tooltip: {
                        backgroundColor: getThemeColors().tooltipBg,
                        titleColor: getThemeColors().tooltipText,
                        bodyColor: getThemeColors().tooltipText,
                        borderColor: getThemeColors().border,
                        borderWidth: 1,
                    },
                },
                scales: {
                    x: {
                        grid: { display: false, color: getThemeColors().grid },
                        ticks: { display: false },
                        border: { display: false },
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: getThemeColors().grid },
                        ticks: { color: getThemeColors().text, font: { size: 12, weight: '600' } },
                        border: { color: getThemeColors().border },
                    },
                },
            },
            plugins: [chartBackgroundPlugin],
        });

        const applyTheme = () => {
            const colors = getThemeColors();

            if (wrapper) {
                wrapper.style.backgroundColor = colors.wrapperBg;
            }
            canvas.style.backgroundColor = colors.canvasBg;
            canvas.style.borderRadius = '1rem';
            chart.options.plugins.chartBackground.backgroundColor = colors.canvasBg;
            chart.options.plugins.legend.labels.color = colors.text;
            chart.options.plugins.tooltip.backgroundColor = colors.tooltipBg;
            chart.options.plugins.tooltip.titleColor = colors.tooltipText;
            chart.options.plugins.tooltip.bodyColor = colors.tooltipText;
            chart.options.scales.x.ticks.color = colors.text;
            chart.options.scales.x.grid.color = colors.grid;
            chart.options.scales.x.border.color = colors.border;
            chart.options.scales.y.ticks.color = colors.text;
            chart.options.scales.y.grid.color = colors.grid;
            chart.options.scales.y.border.color = colors.border;

            chart.update();
        };

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    applyTheme();
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });

        applyTheme();
    });
</script>
@endsection
