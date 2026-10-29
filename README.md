# SIM Pustaka Jurnal (Laravel)

Implementasi Fase 1 dari BRD: pencatatan jurnal terstruktur untuk mahasiswa tingkat akhir.
Berisi source aplikasi saja; framework Laravel dipasang lewat Composer. Target: Laravel 11 atau 12, PHP 8.2+.

## Pasang

```bash
composer create-project laravel/laravel pustaka-jurnal
cp -r app database resources routes pustaka-jurnal/   # jalankan dari folder zip ini
cd pustaka-jurnal
php artisan migrate --seed
php artisan storage:link
# jika project sudah berjalan dan hanya memperbarui file: php artisan migrate
php artisan serve
```

Buka http://127.0.0.1:8000. Akun demo (hanya untuk lokal): demo@pustaka.test / password.
Untuk unggah PDF sampai 20 MB, naikkan `upload_max_filesize` dan `post_max_size` di php.ini ke 20M.

## Sudah ada

FR-01 sampai FR-04 (tambah, ubah, hapus referensi, lampiran PDF atau tautan, status baca), FR-07 dan FR-08 (catatan terstruktur dan bebas), FR-10 dan FR-11 (pencarian, filter status dan tag), FR-14 dan FR-16 (jurnal target dan tabel perbandingan), FR-21 (akun, data antarpengguna terpisah), FR-22 (dashboard dengan tiga diagram lingkaran: status baca, kelengkapan metode, jurnal target menurut biaya; plus daftar lanjutkan membaca, terbaru, dan jurnal target), serta BRL-01 dan BRL-02.

## Belum ada

Riwayat kata kunci pencarian sebagai entitas tersendiri (FR-13; saat ini kata kunci disimpan per referensi lewat kolom Kata kunci pencarian), impor Word atau CSV (FR-18), ekspor, deteksi duplikat, tempat sampah, relasi referensi ke banyak jurnal target, dan berbagi dengan dosen pembimbing.

## Catatan

Kode ini belum dijalankan karena lingkungan penyusun tidak memiliki PHP. Jalankan `php artisan migrate --seed` dan coba alurnya sebelum dipakai.
"# pustaka-jurnal" 
