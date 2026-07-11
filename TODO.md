# TODO - Perbaikan Fitur Scan Dokumen

## Rencana
1. Tambahkan logging debug pada alur scan untuk mengetahui apakah hasil kosong karena Gemini gagal/parsing, atau PDF/ekstraksi teks.
2. Perbaiki `GeminiService::callApi()` agar pengambilan `text` tidak hardcode index `parts[0]`, melainkan mencari text pertama yang tersedia.
3. Tambahkan fallback OCR saat Gemini tidak aktif untuk file gambar (JPG/PNG), lalu gunakan `legacyExtract()` dari hasil OCR.
4. Jalankan testing pada 3 skenario: PDF+Gemini aktif, PDF+Gemini nonaktif, Gambar+Gemini nonaktif.

## Status
- [x] Step 1: Logging debug
- [x] Step 2: Robust parsing response Gemini
- [x] Step 3: OCR fallback untuk gambar
- [ ] Step 4: Testing & verifikasi


