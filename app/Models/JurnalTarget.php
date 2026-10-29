<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalTarget extends Model
{
    protected $table = 'jurnal_targets';

    protected $guarded = [];

    protected $casts = ['indeks_terverifikasi' => 'boolean'];

    public function referensis()
    {
        return $this->hasMany(Referensi::class);
    }

    public function biayaLabel(): string
    {
        return match ($this->jenis_biaya) {
            'gratis' => 'Gratis',
            'berbayar' => 'Rp '.number_format((int) $this->biaya, 0, ',', '.'),
            default => 'Belum diketahui',
        };
    }
}
