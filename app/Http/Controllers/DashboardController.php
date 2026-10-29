<?php

namespace App\Http\Controllers;

use App\Models\JurnalTarget;
use App\Models\Referensi;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $uid = auth()->id();
        $base = Referensi::where('user_id', $uid);

        $counts = (clone $base)->selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');
        $total = (int) $counts->sum();

        $warna = ['belum_dibaca' => 'var(--mute)', 'sedang_dibaca' => 'var(--warn)', 'selesai' => 'var(--acc)', 'dipakai' => 'var(--ind)'];
        $pieStatus = [];
        foreach (Referensi::STATUS as $k => $label) {
            $pieStatus[$label] = [
                'n' => (int) ($counts[$k] ?? 0),
                'color' => $warna[$k],
                'url' => route('referensi.index', ['status' => $k]),
            ];
        }

        $metode = (clone $base)->selectRaw('kelengkapan_metode as k, count(*) as n')->groupBy('kelengkapan_metode')->pluck('n', 'k');
        $lengkap = (int) ($metode['lengkap'] ?? 0);
        $cukup = (int) ($metode['cukup'] ?? 0);
        $kurang = (int) ($metode['kurang'] ?? 0);
        $pieMetode = [
            'Lengkap' => ['n' => $lengkap, 'color' => 'var(--acc)'],
            'Cukup' => ['n' => $cukup, 'color' => 'var(--warn)'],
            'Kurang' => ['n' => $kurang, 'color' => 'var(--bad)'],
            'Belum dinilai' => ['n' => max(0, $total - $lengkap - $cukup - $kurang), 'color' => 'var(--line)'],
        ];

        $biaya = JurnalTarget::where('user_id', $uid)->selectRaw('jenis_biaya as k, count(*) as n')->groupBy('jenis_biaya')->pluck('n', 'k');
        $pieBiaya = [
            'Gratis' => ['n' => (int) ($biaya['gratis'] ?? 0), 'color' => 'var(--acc)'],
            'Berbayar' => ['n' => (int) ($biaya['berbayar'] ?? 0), 'color' => 'var(--ind)'],
            'Belum diketahui' => ['n' => (int) ($biaya['belum_diketahui'] ?? 0), 'color' => 'var(--mute)'],
        ];

        return view('dashboard', [
            'total' => $total,
            'selesai' => (int) (($counts['selesai'] ?? 0) + ($counts['dipakai'] ?? 0)),
            'pieStatus' => $pieStatus,
            'pieMetode' => $pieMetode,
            'pieBiaya' => $pieBiaya,
            'tanpaSumber' => (clone $base)->whereNull('file_pdf')->whereNull('url_artikel')->count(),
            'lanjut' => (clone $base)->where('status', 'sedang_dibaca')->latest('updated_at')->limit(5)->get(),
            'terbaru' => (clone $base)->latest()->limit(5)->get(),
            'jurnals' => JurnalTarget::where('user_id', $uid)->orderBy('nama')->limit(5)->get(),
            'jurnalTotal' => JurnalTarget::where('user_id', $uid)->count(),
        ]);
    }
}
