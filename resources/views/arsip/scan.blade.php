@extends('layouts.app')
@section('title', 'Scan Dokumen')

@section('content')
<div class="max-w-xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Scan Dokumen</h1>
        <p class="mt-1 text-sm text-slate-500">Upload dokumen untuk mengisi data arsip secara otomatis.</p>
    </div>

    {{-- Status AI --}}
    @if($geminiAktif)
        <div class="mb-5 flex items-center gap-3 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 px-4 py-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shrink-0">AI</div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Gemini AI Aktif ✨</p>
                <p class="text-xs text-blue-600">Dokumen akan dianalisis menggunakan Google Gemini untuk hasil yang lebih presisi.</p>
            </div>
        </div>
    @else
        <div class="mb-5 flex items-center gap-3 rounded-2xl bg-amber-50 border border-amber-100 px-4 py-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-400 text-white text-xs font-bold shrink-0">!</div>
            <div>
                <p class="text-sm font-semibold text-amber-800">Mode Dasar Aktif</p>
                <p class="text-xs text-amber-600">Gemini AI belum dikonfigurasi. Sistem menggunakan deteksi teks biasa (akurasi terbatas).</p>
            </div>
        </div>
    @endif

    {{-- Error --}}
    @if($errors->any())
        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3">
            <p class="text-sm font-semibold text-red-700 mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Upload --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <form method="POST"
              action="{{ route('arsip.scan.process') }}"
              enctype="multipart/form-data"
              id="scan-form">
            @csrf

            {{-- Drop zone --}}
            <label for="file-input"
                   class="group flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-colors">

                <div id="drop-placeholder" class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-600 group-hover:text-blue-700">Klik untuk pilih atau drag & drop</p>
                    <p class="text-xs text-slate-400">PDF, JPG, PNG — maks. 10 MB</p>
                </div>

                <div id="file-preview" class="hidden flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p id="file-name" class="text-sm font-semibold text-slate-800 text-center px-4"></p>
                    <p class="text-xs text-blue-500 underline">Ganti file</p>
                </div>
            </label>

            <input id="file-input" type="file" name="file"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="hidden">

            {{-- Tombol Submit --}}
            <button type="submit" id="submit-btn"
                    class="mt-5 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white py-3 rounded-xl font-semibold text-sm transition-all">
                <svg id="btn-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
                <span id="btn-text">{{ $geminiAktif ? 'Analisis dengan Gemini AI' : 'Mulai Scan' }}</span>
            </button>

        </form>

        {{-- Info proses --}}
        <div id="loading-info" class="hidden mt-4 rounded-xl bg-blue-50 border border-blue-100 px-4 py-3">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500 animate-spin shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Sedang menganalisis dokumen...</p>
                    <p class="text-xs text-blue-500">Harap tunggu, proses ini membutuhkan beberapa detik.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Keterangan cara kerja --}}
    <div class="mt-5 rounded-2xl bg-slate-50 border border-slate-100 p-5">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Cara Kerja</p>
        <ol class="space-y-2">
            <li class="flex items-start gap-3">
                <span class="shrink-0 w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center">1</span>
                <p class="text-sm text-slate-600">Upload dokumen PDF atau foto surat/berkas desa.</p>
            </li>
            <li class="flex items-start gap-3">
                <span class="shrink-0 w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center">2</span>
                <p class="text-sm text-slate-600">{{ $geminiAktif ? 'Gemini AI membaca dan mengekstrak informasi (judul, nomor, tanggal, kategori, deskripsi).' : 'Sistem mendeteksi teks menggunakan pencocokan pola.' }}</p>
            </li>
            <li class="flex items-start gap-3">
                <span class="shrink-0 w-5 h-5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center">3</span>
                <p class="text-sm text-slate-600">Form pengisian arsip akan terisi otomatis. Kamu tetap bisa mengedit sebelum menyimpan.</p>
            </li>
        </ol>
    </div>

</div>

<script>
(function () {
    const input      = document.getElementById('file-input');
    const placeholder = document.getElementById('drop-placeholder');
    const preview    = document.getElementById('file-preview');
    const fileName   = document.getElementById('file-name');
    const form       = document.getElementById('scan-form');
    const btn        = document.getElementById('submit-btn');
    const btnText    = document.getElementById('btn-text');
    const loadingInfo = document.getElementById('loading-info');

    input.addEventListener('change', function () {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
            preview.classList.add('flex');
        }
    });

    form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btnText.textContent = 'Menganalisis...';
        loadingInfo.classList.remove('hidden');
    });
})();
</script>
@endsection