@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="w-full overflow-x-auto pb-4">
    <div class="min-w-[600px] space-y-6"> 



<div class="space-y-6">
    <!-- Top Stats -->
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

    <!-- Main Content Grid -->
    <div class="grid gap-4 xl:grid-cols-3">
        <section class="xl:col-span-2 space-y-4">
            
            <!-- Ringkasan Arsip -->
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

            <!-- Kolom Chart: jumlah dokumen per kategori -->
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dark:border-slate-800/30 dark:bg-[#0f172a]">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Statistik Arsip</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900 dark:text-slate-100">Jumlah per Kategori</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 dark:bg-slate-800/60 dark:text-slate-200">Breakdown</span>
                </div>

                <div class="mt-6">
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 dark:border-slate-700/50 dark:bg-[#111c33]/60">
                        <!-- Tinggi div dinaikkan agar legend punya ruang lebih -->
                        <!-- Bagian yang baru (Responsive Height) -->
<div class="relative h-64 md:h-[320px] overflow-hidden rounded-2xl">
    <canvas id="arsipPerKategoriChart" class="h-full w-full"></canvas>
</div>
                    </div>
                </div>
            </div>

            <!-- Arsip Terbaru -->
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

            <!-- Chart.js + inisialisasi -->
            <div class="grid gap-4 grid-cols-1 xl:grid-cols-3">
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const canvas = document.getElementById('arsipPerKategoriChart');
                    if (!canvas || !window.Chart) return;

                    const labels = @json($arsipPerKategori->pluck('nama')->values());
                    const data = @json($arsipPerKategori->pluck('arsips_count')->values());

                    const isDark = document.documentElement.classList.contains('dark');
                    const themeToggleButton = document.getElementById('theme-toggle');

                    // Definisi Variasi Warna Baris (Palette)
                    const colorPalette = [
                        { bg: 'rgba(59, 130, 246, 0.85)', border: 'rgb(59, 130, 246)' },  // Blue
                        { bg: 'rgba(16, 185, 129, 0.85)', border: 'rgb(16, 185, 129)' },  // Emerald
                        { bg: 'rgba(245, 158, 11, 0.85)', border: 'rgb(245, 158, 11)' },  // Amber
                        { bg: 'rgba(239, 68, 68, 0.85)',  border: 'rgb(239, 68, 68)' },   // Red
                        { bg: 'rgba(139, 92, 246, 0.85)', border: 'rgb(139, 92, 246)' },  // Violet
                        { bg: 'rgba(6, 182, 212, 0.85)',  border: 'rgb(6, 182, 212)' },   // Cyan
                        { bg: 'rgba(236, 72, 153, 0.85)', border: 'rgb(236, 72, 153)' },  // Pink
                        { bg: 'rgba(249, 115, 22, 0.85)', border: 'rgb(249, 115, 22)' },  // Orange
                    ];

                    // Melakukan mapping warna sesuai jumlah kategori (berulang jika jumlah label lebih dari warna palette)
                    const backgroundColors = labels.map((_, i) => colorPalette[i % colorPalette.length].bg);
                    const borderColors = labels.map((_, i) => colorPalette[i % colorPalette.length].border);

                    // Konfigurasi responsif mode terang/gelap untuk text dan grid
                    const getThemeConfig = (darkMode) => ({
                        grid: darkMode ? 'rgba(148, 163, 184, 0.15)' : 'rgba(15, 23, 42, 0.08)',
                        text: darkMode ? '#e2e8f0' : '#475569',
                        tooltipBg: darkMode ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                        tooltipBorder: darkMode ? 'rgba(148, 163, 184, 0.35)' : 'rgba(15, 23, 42, 0.10)',
                    });

                    let themeConfig = getThemeConfig(isDark);

                    const applyTheme = () => {
                        const darkNow = document.documentElement.classList.contains('dark');
                        const newConfig = getThemeConfig(darkNow);

                        chart.options.scales.y.grid.color = newConfig.grid;
                        chart.options.scales.x.grid.color = newConfig.grid;
                        chart.options.scales.x.ticks.color = newConfig.text;
                        chart.options.scales.y.ticks.color = newConfig.text;

                        chart.options.plugins.tooltip.backgroundColor = newConfig.tooltipBg;
                        chart.options.plugins.tooltip.titleColor = newConfig.text;
                        chart.options.plugins.tooltip.bodyColor = newConfig.text;
                        chart.options.plugins.tooltip.borderColor = newConfig.tooltipBorder;

                        // Update warna text pada Legend
                        chart.options.plugins.legend.labels.color = newConfig.text;

                        chart.update();
                    };

                    const chart = new Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [
                                {
                                    label: 'Jumlah Arsip',
                                    data,
                                    backgroundColor: backgroundColors, // Terapkan array warna
                                    borderColor: borderColors,         // Terapkan array warna
                                    borderWidth: 1,
                                    borderRadius: 8,
                                    maxBarThickness: 48
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 500 },
                            plugins: {
                                legend: {
                                    display: true, 
                                    position: 'bottom', // Legend ditempatkan di bawah
                                    labels: {
                                        color: themeConfig.text,
                                        usePointStyle: true, // Marker legend menjadi bentuk bulat (lebih rapi)
                                        boxWidth: 10,
                                        padding: 15,
                                        font: { size: 12 },
                                        // Customisasi label legend agar membaca per Kategori (Baris) bukan nama Datasetnya
                                        generateLabels: (chart) => {
                                            const data = chart.data;
                                            if (data.labels.length && data.datasets.length) {
                                                return data.labels.map((label, i) => {
                                                    const meta = chart.getDatasetMeta(0);
                                                    return {
                                                        text: label,
                                                        fillStyle: backgroundColors[i],
                                                        strokeStyle: borderColors[i],
                                                        lineWidth: 1,
                                                        // Menyembunyikan baris jika legend ditekan
                                                        hidden: isNaN(data.datasets[0].data[i]) || meta.data[i].hidden,
                                                        index: i
                                                    };
                                                });
                                            }
                                            return [];
                                        }
                                    },
                                    // Aksi klik legend agar bisa menghilangkan/menampilkan baris grafik tertentu
                                    onClick: (e, legendItem, legend) => {
                                        const index = legendItem.index;
                                        const chart = legend.chart;
                                        const meta = chart.getDatasetMeta(0);
                                        // Toggle sembunyikan/munculkan data
                                        meta.data[index].hidden = !meta.data[index].hidden;
                                        chart.update();
                                    }
                                },
                                tooltip: {
                                    backgroundColor: themeConfig.tooltipBg,
                                    titleColor: themeConfig.text,
                                    bodyColor: themeConfig.text,
                                    borderColor: themeConfig.tooltipBorder,
                                    borderWidth: 1,
                                    padding: 10
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        display: false // MENGHILANGKAN teks miring (label kategori) di sumbu X
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: themeConfig.grid,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: themeConfig.text,
                                        font: { size: 12 },
                                        precision: 0 // Pastikan angka bulat
                                    }
                                }
                            }
                        }
                    });

                    // Update chart saat toggle tema diklik
                    if (themeToggleButton) {
                        themeToggleButton.addEventListener('click', () => {
                            setTimeout(() => applyTheme(), 10);
                        });
                    }

                    // Deteksi perubahan otomatis (System Preference / Tailwind class mutation)
                    const observer = new MutationObserver(() => applyTheme());
                    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

                    canvas.__chart = chart;
                });
            </script>
        </section>
</div>

        <!-- Sidebar -->
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
    </div>
</div>
@endsection