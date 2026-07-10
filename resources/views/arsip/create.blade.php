@extends('layouts.app')
@section('title', 'Tambah Arsip')

@section('content')

<div class="max-w-2xl">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Tambah Arsip</h1>
        <p class="mt-1 text-sm text-slate-500">Isi data dokumen arsip yang akan disimpan.</p>
    </div>

    {{-- Banner hasil scan AI --}}
    @if(isset($hasilScan))
        @if(!empty($hasilScan['ai_powered']))
            <div class="mb-5 flex items-start gap-3 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 px-4 py-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shrink-0 mt-0.5">AI</div>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Dianalisis oleh Gemini AI ✨</p>
                    <p class="text-xs text-blue-600 mt-0.5">Field di bawah telah diisi otomatis berdasarkan hasil analisis AI. Periksa dan koreksi jika diperlukan sebelum menyimpan.</p>
                </div>
            </div>
        @else
            <div class="mb-5 flex items-center gap-3 rounded-2xl bg-green-50 border border-green-200 px-4 py-3">
                <span class="text-green-600 text-lg">✅</span>
                <div>
                    <p class="text-sm font-semibold text-green-800">Hasil Scan Dokumen</p>
                    <p class="text-xs text-green-600">Sistem berhasil membaca dokumen. Silakan periksa kembali sebelum menyimpan.</p>
                </div>
            </div>
        @endif
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <form method="POST"
              action="{{ route('arsip.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Judul --}}
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-slate-700">Judul Arsip <span class="text-red-500">*</span></label>
                        @if(isset($hasilScan['judul']) && $hasilScan['judul'])
                            <span class="text-xs text-blue-500 font-medium">✨ Diisi AI</span>
                        @endif
                    </div>
                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $hasilScan['judul'] ?? '') }}"
                           required
                           placeholder="Contoh: Surat Keputusan Kepala Desa"
                           class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent {{ (isset($hasilScan['judul']) && $hasilScan['judul']) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                    @error('judul')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>


                {{-- Kategori --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-slate-700">Kategori <span class="text-red-500">*</span></label>
                        @if(isset($hasilScan['kategori_id']) && $hasilScan['kategori_id'])
                            <span class="text-xs text-blue-500 font-medium">✨ Diisi AI</span>
                        @endif
                    </div>
                    <select name="kategori_id"
                            required
                            class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent {{ (isset($hasilScan['kategori_id']) && $hasilScan['kategori_id']) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                @selected(old('kategori_id', $hasilScan['kategori_id'] ?? '') == $kategori->id)>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>


                {{-- Nomor Arsip --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-slate-700">Nomor Arsip <span class="text-slate-400 font-normal">(opsional)</span></label>
                        @if(isset($hasilScan['nomor_arsip']) && $hasilScan['nomor_arsip'])
                            <span class="text-xs text-blue-500 font-medium">✨ Diisi AI</span>
                        @endif
                    </div>
                    <input type="text"
                           name="nomor_arsip"
                           value="{{ old('nomor_arsip', $hasilScan['nomor_arsip'] ?? '') }}"
                           placeholder="Contoh: 001/DS-BJL/I/2025"
                           class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent {{ (isset($hasilScan['nomor_arsip']) && $hasilScan['nomor_arsip']) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                </div>


                {{-- Tanggal --}}
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-slate-700">Tanggal Arsip <span class="text-red-500">*</span></label>
                        @if(isset($hasilScan['tanggal_arsip']) && $hasilScan['tanggal_arsip'])
                            <span class="text-xs text-blue-500 font-medium">✨ Diisi AI</span>
                        @endif
                    </div>
                    <input type="date"
                           name="tanggal_arsip"
                           value="{{ old('tanggal_arsip', $hasilScan['tanggal_arsip'] ?? '') }}"
                           required
                           class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent {{ (isset($hasilScan['tanggal_arsip']) && $hasilScan['tanggal_arsip']) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                    @error('tanggal_arsip')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>


                {{-- File --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">File Dokumen</label>

                    @if(isset($hasilScan['file_path']))
                        <div class="flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-800">File hasil scan siap</p>
                                <p class="text-xs text-green-600">{{ basename($hasilScan['file_path']) }}</p>
                            </div>
                        </div>
                    @else
                        <input type="file"
                               name="file"
                               required
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 file:text-xs file:font-medium">
                        <p class="text-xs text-slate-400 mt-1.5">PDF, gambar, atau dokumen Office. Maks. 10 MB.</p>
                        @error('file')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    @endif
                </div>


                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-slate-700">Deskripsi / Keterangan <span class="text-slate-400 font-normal">(opsional)</span></label>
                        @if(isset($hasilScan['deskripsi']) && $hasilScan['deskripsi'])
                            <span class="text-xs text-blue-500 font-medium">✨ Diisi AI</span>
                        @endif
                    </div>
                    <textarea name="deskripsi"
                              rows="3"
                              placeholder="Ringkasan singkat isi dokumen..."
                              class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent {{ (isset($hasilScan['deskripsi']) && $hasilScan['deskripsi']) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">{{ old('deskripsi', $hasilScan['deskripsi'] ?? '') }}</textarea>
                </div>


            </div>


            <div class="flex gap-3 pt-1">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                    Simpan Arsip
                </button>
                <a href="{{ route('arsip.index') }}"
                   class="flex items-center px-5 py-2.5 text-sm text-slate-500 hover:text-slate-700 rounded-xl hover:bg-slate-100 transition-colors">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection