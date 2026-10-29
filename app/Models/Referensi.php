<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    public const STATUS = [
        'belum_dibaca' => 'Belum dibaca',
        'sedang_dibaca' => 'Sedang dibaca',
        'selesai' => 'Selesai dibaca',
        'dipakai' => 'Dipakai di naskah',
    ];

    protected $table = 'referensis';

    protected $guarded = [];

    public function jurnalTarget()
    {
        return $this->belongsTo(JurnalTarget::class);
    }

    public function tagList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->tags))));
    }
}
