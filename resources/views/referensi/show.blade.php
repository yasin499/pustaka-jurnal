@extends('layouts.app')
@section('title', $referensi->judul)
@section('content')
<div class="head">
  <h1>{{ $referensi->judul }}</h1>
  <div>
    <a class="btn alt" href="{{ route('referensi.edit', $referensi) }}">Ubah</a>
    <form class="inline" method="post" action="{{ route('referensi.destroy', $referensi) }}" onsubmit="return confirm('Hapus referensi ini?')">
      @csrf @method('DELETE')
      <button class="link bad">Hapus</button>
    </form>
  </div>
</div>

<p class="item s-{{ $referensi->status }}">
  <span class="st">{{ \App\Models\Referensi::STATUS[$referensi->status] ?? $referensi->status }}</span>
  <span class="mute">{{ collect([$referensi->penulis, $referensi->tahun])->filter()->join(', ') }}</span><br>
  @if($referensi->file_pdf)<a href="{{ asset('storage/'.$referensi->file_pdf) }}" target="_blank" rel="noopener">Buka PDF</a>@endif
  @if($referensi->url_artikel)<a class="inline" href="{{ $referensi->url_artikel }}" target="_blank" rel="noopener">Buka tautan artikel</a>@endif
  @if($referensi->jurnalTarget)<br>Jurnal target: {{ $referensi->jurnalTarget->nama }} ({{ $referensi->jurnalTarget->biayaLabel() }})@endif
  @if($referensi->relevansi)<br>Relevansi: {{ $referensi->relevansi }} dari 5 @endif
</p>

@foreach(['kata_kunci' => 'Kata kunci pencarian', 'metode' => 'Metode', 'permasalahan' => 'Permasalahan', 'temuan' => 'Temuan', 'keterbatasan' => 'Keterbatasan atau celah', 'catatan' => 'Catatan'] as $f => $label)
  @if($referensi->$f)
    <section>
      <h2>{{ $label }}@if($f === 'metode' && $referensi->kelengkapan_metode) <small>(kelengkapan: {{ $referensi->kelengkapan_metode }})</small>@endif</h2>
      <p>{!! nl2br(e($referensi->$f)) !!}</p>
    </section>
  @endif
@endforeach

@foreach($referensi->tagList() as $t)<a class="chip" href="{{ route('referensi.index', ['tag' => $t]) }}">{{ $t }}</a>@endforeach
<p><a href="{{ route('referensi.index') }}">Kembali ke daftar</a></p>
@endsection
