<?php

namespace Database\Seeders;

use App\Models\JurnalTarget;
use App\Models\Referensi;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data contoh dari pustaka.docx. Akun demo hanya untuk pengembangan lokal.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $u = User::firstOrCreate(
            ['email' => 'demo@pustaka.test'],
            ['name' => 'Mahasiswa Demo', 'password' => 'password']
        );

        if (Referensi::where('user_id', $u->id)->exists()) {
            return;
        }

        $jurnal = fn (array $d) => JurnalTarget::create($d + ['user_id' => $u->id]);

        $factory = $jurnal(['nama' => 'Factory (Ilmu Bersama)', 'url' => 'https://jurnal.ilmubersama.com/index.php/factory/article/view/1643', 'jenis_biaya' => 'berbayar', 'biaya' => 500000]);
        $jutisi = $jurnal(['nama' => 'JUTISI (Maranatha)', 'url' => 'https://journal.maranatha.edu/index.php/jutisi/indexers', 'jenis_biaya' => 'gratis', 'biaya' => 0, 'indeks' => 'SINTA 3', 'catatan' => 'Gratis dan SINTA 3 menurut catatan awal; belum diverifikasi.']);
        $unilak = $jurnal(['nama' => 'Jurnal Unilak (zn)', 'url' => 'https://journal.unilak.ac.id/index.php/zn/article/view/30121', 'jenis_biaya' => 'berbayar', 'biaya' => 600000, 'periode_terbit' => 'Maret, Agustus, September']);

        $ref = fn (array $d) => Referensi::create($d + ['user_id' => $u->id, 'status' => 'belum_dibaca']);

        $ref(['judul' => 'Usulan Business Process Reengineering untuk Optimalisasi Proses Operasional pada UMKM XYZ', 'kelengkapan_metode' => 'lengkap', 'permasalahan' => 'Efisiensi waktu pemesanan', 'tags' => 'BPR, UMKM', 'jurnal_target_id' => $factory->id]);
        $ref(['judul' => 'Strategi Bisnis Clothing Line Berbasis Business Model Canvas dan Manajemen Hubungan Pelanggan', 'tags' => 'Business Model Canvas, CRM', 'jurnal_target_id' => $jutisi->id]);
        $ref(['judul' => 'Analisis Sistem Pendataan Anak Asuh', 'kata_kunci' => '"Pendataan anak" AND "digitalisasi"', 'tags' => 'Sistem informasi, Digitalisasi', 'jurnal_target_id' => $unilak->id]);
        $ref(['judul' => 'Implementasi Inovasi Sistem Informasi Layanan Anak Tidak Sekolah (SILAT) dalam Mendukung Pengentasan Anak Tidak Sekolah di Kabupaten Blora', 'catatan' => 'Catatan di dokumen asal terpotong. Lengkapi setelah dibaca.', 'tags' => 'Sistem informasi']);
    }
}
