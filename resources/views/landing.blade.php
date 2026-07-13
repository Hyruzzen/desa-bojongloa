<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title>E-Arsip Desa Bojongloa – Sistem Pengelolaan Arsip Digital Resmi | Rancaekek, Bandung</title>
    <meta name="description" content="Portal arsip digital resmi Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung. Temukan surat, peraturan desa, data kependudukan, dan dokumen resmi lainnya dengan cepat menggunakan teknologi AI.">
    <meta name="keywords" content="e-arsip bojongloa, arsip desa bojongloa, surat desa bojongloa, rancaekek bandung, administrasi desa bojongloa, dokumen digital desa, sistem arsip desa, bojongloa desa id, kantor desa bojongloa">
    <meta name="author" content="Pemerintah Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <meta name="geo.region" content="ID-JB">
    <meta name="geo.placename" content="Desa Bojongloa, Rancaekek, Bandung">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="E-Arsip Desa Bojongloa – Sistem Pengelolaan Arsip Digital Resmi">
    <meta property="og:description" content="Portal arsip digital resmi Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung. Didukung AI OCR untuk pengelolaan dokumen yang lebih mudah dan cepat.">
    <meta property="og:image" content="{{ asset('images/hero.png') }}">
    <meta property="og:site_name" content="E-Arsip Desa Bojongloa">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="E-Arsip Desa Bojongloa – Sistem Pengelolaan Arsip Digital Resmi">
    <meta name="twitter:description" content="Portal arsip digital resmi Desa Bojongloa, Rancaekek, Bandung.">
    <meta name="twitter:image" content="{{ asset('images/hero.png') }}">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "GovernmentService",
        "name": "E-Arsip Desa Bojongloa",
        "alternateName": "Portal Arsip Digital Desa Bojongloa",
        "description": "Sistem informasi pengelolaan dan pengarsipan dokumen digital resmi Pemerintah Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung, Provinsi Jawa Barat.",
        "url": "{{ url('/') }}",
        "provider": {
            "@@type": "GovernmentOrganization",
            "name": "Pemerintah Desa Bojongloa",
            "sameAs": "https://bojongloa.desa.id",
            "address": {
                "@@type": "PostalAddress",
                "addressLocality": "Rancaekek",
                "addressRegion": "Bandung",
                "addressCountry": "ID"
            }
        },
        "areaServed": {
            "@@type": "Place",
            "name": "Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung"
        }
    }
    </script>

    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .hero-gradient {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 50%, #1a1a2e 100%);
        }

        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .badge-pulse::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .news-card:hover .news-title {
            color: #2563eb;
        }

        .scroll-fade {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .scroll-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .hero-text { font-size: 2rem; line-height: 1.2; }
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100">

    <!-- ===== NAVBAR ===== -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/40 dark:bg-slate-950/40 backdrop-blur-md border-b border-white/20 dark:border-slate-800/30 transition-colors">
        <div class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between gap-4">

            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-md text-white font-black text-sm">EA</div>
                <div class="hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">E-Arsip Bojongloa</p>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">Kec. Rancaekek · Kab. Bandung</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1">
                <a href="#tentang" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-all">Tentang</a>
                <a href="#fitur" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-all">Fitur</a>
                <a href="#berita" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-all">Berita Desa</a>
                <a href="#kontak" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-all">Kontak</a>
            </nav>

            <!-- CTA -->
            <div class="flex items-center gap-4">
                <a href="https://bojongloa.desa.id" target="_blank" rel="noopener noreferrer" class="hidden sm:block text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    Website Desa ↗
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-black dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-200 text-white dark:text-black text-xs font-semibold px-6 py-2.5 rounded-full shadow transition-all active:scale-95 tracking-wider uppercase">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-black dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-200 text-white dark:text-black text-xs font-semibold px-6 py-2.5 rounded-full shadow transition-all active:scale-95 tracking-wider uppercase">
                        Masuk Sistem
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>

        <!-- ===== HERO ===== -->
        <section class="min-h-screen grid grid-cols-1 lg:grid-cols-2 relative bg-[#eef1f4] dark:bg-slate-900">
            <!-- Copy (Left) -->
            <div class="flex flex-col justify-center items-start px-8 py-32 lg:px-20 xl:px-32 relative z-10 w-full h-full">
                <div class="max-w-lg">
                    <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 mb-6 font-medium tracking-wide">
                        E-Arsip Desa Bojongloa?
                    </p>

                    <h1 class="text-5xl md:text-6xl xl:text-7xl font-medium text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-8">
                        Arsip Dokumen<br>
                        Digital
                    </h1>

                    <p class="text-base text-slate-600 dark:text-slate-300 leading-relaxed mb-12">
                        Kelola administrasi desa, temukan surat, peraturan, dan data kependudukan warga dengan cepat serta terorganisir.
                    </p>

                    <div>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-block bg-black dark:bg-white text-white dark:text-black font-semibold text-xs tracking-widest uppercase px-9 py-3.5 rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95 hover:bg-slate-800 dark:hover:bg-slate-200">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-black dark:bg-white text-white dark:text-black font-semibold text-xs tracking-widest uppercase px-9 py-3.5 rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95 hover:bg-slate-800 dark:hover:bg-slate-200">
                                Lihat Sistem
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Image (Right) -->
            <div class="relative h-96 lg:h-full w-full lg:min-h-screen order-first lg:order-last">
                <img src="{{ asset('images/hero.png') }}" alt="Arsip Digital Bojongloa" class="absolute inset-0 w-full h-full object-cover">
            </div>
        </section>

        <!-- ===== TENTANG DESA ===== -->
        <section id="tentang" class="py-20 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <!-- Info cards left -->
                    <div class="grid grid-cols-2 gap-4 scroll-fade">
                        <div class="col-span-2 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl p-6 shadow-lg">
                            <div class="text-3xl mb-3">🏛️</div>
                            <h3 class="font-bold text-lg">Desa Bojongloa</h3>
                            <p class="text-blue-100 text-sm mt-1">Kecamatan Rancaekek, Kabupaten Bandung, Provinsi Jawa Barat</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-800">
                            <div class="text-2xl mb-2">📜</div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Sejarah Panjang</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Desa dengan rekam jejak pemerintahan yang kaya</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-800">
                            <div class="text-2xl mb-2">👥</div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Masyarakat Aktif</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Warga yang dinamis dengan berbagai potensi lokal</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-800">
                            <div class="text-2xl mb-2">🗺️</div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Wilayah Strategis</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Akses mudah di kawasan industri Rancaekek</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-800">
                            <div class="text-2xl mb-2">🌱</div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Potensi Lokal</p>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Produk dan BUMDES yang terus berkembang</p>
                        </div>
                    </div>

                    <!-- Text right -->
                    <div class="scroll-fade space-y-6">
                        <div>
                            <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest mb-3">Profil Singkat Desa</p>
                            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                                Mengenal Lebih Dekat<br>Desa Bojongloa
                            </h2>
                        </div>
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            Desa Bojongloa adalah desa yang terus berkembang di Kecamatan Rancaekek, Kabupaten Bandung. Dengan semangat gotong royong dan dukungan berbagai lembaga desa seperti BPD, LPMD, PKK, dan Karang Taruna, desa ini berkomitmen memberikan pelayanan terbaik kepada warganya.
                        </p>
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            Sebagai bagian dari komitmen tersebut, Pemerintah Desa Bojongloa menghadirkan <strong>sistem e-arsip digital</strong> agar dokumen administrasi desa — mulai dari surat resmi, peraturan desa, hingga data keuangan APBDes — bisa dikelola dengan lebih rapi, transparan, dan mudah diakses kapan saja.
                        </p>

                        <!-- Visi Misi -->
                        <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/50 rounded-2xl p-5 space-y-3">
                            <p class="font-bold text-blue-900 dark:text-blue-300">🎯 Visi & Misi Desa Bojongloa</p>
                            <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                Mewujudkan Desa Bojongloa yang <strong>maju, mandiri, dan sejahtera</strong> melalui tata kelola pemerintahan yang bersih, transparan, dan berorientasi pada pelayanan masyarakat yang prima.
                            </p>
                        </div>

                        <a href="https://bojongloa.desa.id/artikel/2020/3/5/sejarah-desa-bojongloa" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-sm hover:underline">
                            Baca Sejarah Lengkap Desa ↗
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== LAYANAN & FITUR ===== -->
        <section id="fitur" class="py-20 bg-slate-50 dark:bg-slate-900/30">
            <div class="max-w-7xl mx-auto px-5">
                <div class="text-center max-w-2xl mx-auto mb-14 scroll-fade">
                    <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest mb-3">Fitur Unggulan</p>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Pengelolaan Arsip yang Lebih Mudah</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-3">Sistem ini dirancang khusus untuk kebutuhan administrasi desa — simpel, cepat, dan aman.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-blue-100 dark:bg-blue-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">🤖</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Scan AI Otomatis</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Upload foto surat fisik, biarkan AI membaca dan mengisi data arsip secara otomatis. Didukung Tesseract OCR + Gemini AI.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">🔍</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Pencarian Cepat</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Cari dokumen berdasarkan judul, nomor surat, tanggal, atau kategori. Temukan apa pun dalam hitungan detik.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-purple-100 dark:bg-purple-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">📂</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Kategori Terstruktur</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Semua dokumen dikelompokkan rapi: Kependudukan, Keuangan Desa, Surat Resmi, dan Pemerintahan Desa.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-amber-100 dark:bg-amber-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">📊</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Laporan & Ekspor</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Ekspor data arsip ke format CSV, unduh dokumen kapan saja, dan pantau statistik pengarsipan lewat dashboard.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">📋</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Peraturan Desa</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Simpan dan akses produk hukum desa seperti Perdes, SK Kepala Desa, dan dokumen kebijakan resmi lainnya.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-rose-100 dark:bg-rose-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">💰</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Keuangan APBDes</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Arsipkan dokumen anggaran desa, realisasi belanja, dan laporan keuangan APBDes secara tertib dan transparan.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">👤</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Administrasi Kependudukan</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Kelola surat keterangan domisili, KK, data warga, surat kelahiran, kematian, dan dokumen kependudukan lainnya.</p>
                    </div>

                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="w-14 h-14 bg-teal-100 dark:bg-teal-950/50 rounded-2xl flex items-center justify-center text-2xl mb-5">🔒</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2">Aman & Terpercaya</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Dilindungi sistem login dengan autentikasi. Hanya operator resmi desa yang bisa mengakses dan mengelola arsip.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== BERITA DESA ===== -->
        <section id="berita" class="py-20 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-5">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 scroll-fade">
                    <div>
                        <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest mb-2">Info Terbaru</p>
                        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Berita & Kegiatan Desa</h2>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">Kegiatan nyata yang sudah dilaksanakan Pemerintah Desa Bojongloa</p>
                    </div>
                    <a href="https://bojongloa.desa.id" target="_blank" rel="noopener noreferrer" class="shrink-0 text-sm font-semibold text-blue-700 dark:text-blue-400 hover:underline">
                        Lihat Semua Berita ↗
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- News 1 -->
                    <article class="news-card card-hover bg-slate-50 dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 h-36 flex items-center justify-center text-4xl">🕌</div>
                        <div class="p-5">
                            <span class="text-xs font-semibold text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 px-2 py-1 rounded-full">Berita Lokal</span>
                            <h3 class="news-title font-bold text-slate-900 dark:text-white mt-3 mb-2 leading-snug transition-colors">Terawih Keliling Bersama Bupati & Wakil Bupati Bandung di Desa Bojongloa</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Bertempat di Masjid Besar Rancaekek, kegiatan terawih keliling bersama Bupati Bandung berlangsung meriah dengan antusias warga yang tinggi.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-3">📅 23 Februari 2026 · Admin Desa</p>
                        </div>
                    </article>

                    <!-- News 2 -->
                    <article class="news-card card-hover bg-slate-50 dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="bg-gradient-to-br from-green-500 to-teal-600 h-36 flex items-center justify-center text-4xl">🤝</div>
                        <div class="p-5">
                            <span class="text-xs font-semibold text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-950/50 px-2 py-1 rounded-full">Berita Lokal</span>
                            <h3 class="news-title font-bold text-slate-900 dark:text-white mt-3 mb-2 leading-snug transition-colors">Musdes BUMDES di Awal Tahun 2026</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Musyawarah Desa khusus membahas perkembangan BUMDES Bojongloa digelar di Aula Desa untuk merencanakan program ekonomi desa tahun ini.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-3">📅 19 Februari 2026 · Admin Desa</p>
                        </div>
                    </article>

                    <!-- News 3 -->
                    <article class="news-card card-hover bg-slate-50 dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="bg-gradient-to-br from-rose-500 to-pink-600 h-36 flex items-center justify-center text-4xl">🍽️</div>
                        <div class="p-5">
                            <span class="text-xs font-semibold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 px-2 py-1 rounded-full">PKK</span>
                            <h3 class="news-title font-bold text-slate-900 dark:text-white mt-3 mb-2 leading-snug transition-colors">Lomba Cipta Menu Berbahan Lokal dari TP PKK Desa Bojongloa</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Dalam rangka HUT RI ke-80, TP PKK Desa Bojongloa mengadakan lomba cipta menu kreatif berbahan pangan lokal untuk warga.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-3">📅 11 Agustus 2025 · Admin Desa</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ===== STRUKTUR PEMERINTAHAN ===== -->
        <section class="py-20 bg-slate-50 dark:bg-slate-900/30">
            <div class="max-w-7xl mx-auto px-5">
                <div class="text-center max-w-xl mx-auto mb-12 scroll-fade">
                    <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest mb-3">Lembaga Desa</p>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Organisasi Pemerintahan Desa Bojongloa</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-3 text-sm">Berbagai lembaga yang bersinergi untuk kemajuan Desa Bojongloa</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach([
                        ['icon' => '🏠', 'nama' => 'Pemerintah Desa', 'singkatan' => 'Pemdes'],
                        ['icon' => '⚖️', 'nama' => 'Badan Permusyawaratan Desa', 'singkatan' => 'BPD'],
                        ['icon' => '🔨', 'nama' => 'Lembaga Pemberdayaan Masyarakat', 'singkatan' => 'LPMD'],
                        ['icon' => '👩', 'nama' => 'Pemberdayaan Kesejahteraan Keluarga', 'singkatan' => 'PKK'],
                        ['icon' => '🌟', 'nama' => 'Karang Taruna', 'singkatan' => 'Karang Taruna'],
                        ['icon' => '🏪', 'nama' => 'Badan Usaha Milik Desa', 'singkatan' => 'BUMDES'],
                        ['icon' => '🤲', 'nama' => 'Kader Pemberdayaan Masyarakat', 'singkatan' => 'KPM'],
                        ['icon' => '🏥', 'nama' => 'Pusat Kesejahteraan Sosial', 'singkatan' => 'Puskesos'],
                        ['icon' => '👶', 'nama' => 'Pos Keluarga Berencana', 'singkatan' => 'Pos KB'],
                        ['icon' => '💪', 'nama' => 'Pekerja Sosial Masyarakat', 'singkatan' => 'PSM'],
                    ] as $lembaga)
                    <div class="card-hover bg-white dark:bg-slate-900 rounded-2xl p-4 text-center shadow-sm border border-slate-100 dark:border-slate-800 scroll-fade">
                        <div class="text-2xl mb-2">{{ $lembaga['icon'] }}</div>
                        <p class="font-bold text-slate-900 dark:text-white text-xs">{{ $lembaga['singkatan'] }}</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5 leading-snug">{{ $lembaga['nama'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ===== KONTAK ===== -->
        <section id="kontak" class="py-20 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="scroll-fade space-y-6">
                        <div>
                            <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-widest mb-3">Hubungi Kami</p>
                            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Kantor Desa Bojongloa</h2>
                        </div>
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                            Butuh bantuan terkait administrasi atau akses arsip desa? Jangan ragu untuk langsung mendatangi kantor kami atau hubungi via email. Kami dengan senang hati siap membantu!
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-950/50 rounded-xl flex items-center justify-center text-lg shrink-0">📍</div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Alamat Kantor</p>
                                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung, Jawa Barat</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-950/50 rounded-xl flex items-center justify-center text-lg shrink-0">🌐</div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Website Resmi Desa</p>
                                    <a href="https://bojongloa.desa.id" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 text-sm hover:underline mt-0.5 block">bojongloa.desa.id ↗</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-950/50 rounded-xl flex items-center justify-center text-lg shrink-0">🗺️</div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white text-sm">Peta Lokasi</p>
                                    <a href="https://www.openstreetmap.org/#map=15/-6.953265430973999/107.76572942733766" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 text-sm hover:underline mt-0.5 block">Buka di OpenStreetMap ↗</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA box -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-2xl scroll-fade">
                        <div class="text-4xl mb-4">🗂️</div>
                        <h3 class="text-2xl font-extrabold mb-3">Siap Mengelola Arsip Desa?</h3>
                        <p class="text-blue-100 leading-relaxed mb-6">Masuk ke sistem e-arsip dan mulai digitalkan dokumen administrasi Desa Bojongloa sekarang. Lebih cepat, lebih rapi, lebih mudah.</p>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block w-full bg-white text-blue-800 font-bold text-center py-4 rounded-2xl hover:bg-blue-50 transition-colors active:scale-95">
                                Buka Dashboard Arsip →
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-white text-blue-800 font-bold text-center py-4 rounded-2xl hover:bg-blue-50 transition-colors active:scale-95">
                                Masuk ke Portal →
                            </a>
                        @endauth
                        <p class="text-center text-blue-200 text-xs mt-4">Hanya untuk petugas resmi Kantor Desa Bojongloa</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-900 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xs">EA</div>
                        <div>
                            <p class="font-bold text-white text-sm">E-Arsip Desa Bojongloa</p>
                            <p class="text-[10px] text-slate-500">Sistem Pengelolaan Arsip Digital</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Portal resmi pengarsipan dokumen digital Pemerintah Desa Bojongloa, Kecamatan Rancaekek, Kabupaten Bandung.</p>
                </div>
                <div>
                    <p class="font-semibold text-white mb-4 text-sm">Tautan Desa</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://bojongloa.desa.id" target="_blank" class="hover:text-white transition-colors">Website Resmi Desa ↗</a></li>
                        <li><a href="https://bojongloa.desa.id/artikel/2020/3/5/sejarah-desa-bojongloa" target="_blank" class="hover:text-white transition-colors">Sejarah Desa</a></li>
                        <li><a href="https://bojongloa.desa.id/artikel/2020/3/5/visi-misi" target="_blank" class="hover:text-white transition-colors">Visi & Misi</a></li>
                        <li><a href="https://bojongloa.desa.id/peraturan-desa" target="_blank" class="hover:text-white transition-colors">Produk Hukum</a></li>
                        <li><a href="https://bojongloa.desa.id/first/info_keuangan" target="_blank" class="hover:text-white transition-colors">Informasi Keuangan</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-semibold text-white mb-4 text-sm">Sistem Arsip</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk ke Portal</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                            <li><a href="{{ route('arsip.index') }}" class="hover:text-white transition-colors">Daftar Arsip</a></li>
                            <li><a href="{{ route('arsip.scan') }}" class="hover:text-white transition-colors">Scan Dokumen AI</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Pemerintah Desa Bojongloa · Kec. Rancaekek · Kab. Bandung · Jawa Barat</p>
                <p>Sistem E-Arsip Digital v1.0</p>
            </div>
        </div>
    </footer>

    <script>
        // Scroll fade animation
        const fadeEls = document.querySelectorAll('.scroll-fade');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(el => {
                if (el.isIntersecting) {
                    el.target.classList.add('visible');
                    observer.unobserve(el.target);
                }
            });
        }, { threshold: 0.1 });
        fadeEls.forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
