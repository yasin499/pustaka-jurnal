@extends('layouts.app')
@section('title', 'Referensi')
@section('content')
<div class="head">
  <h1>Referensi</h1>
  <a class="btn" href="{{ route('referensi.create') }}">Tambah referensi</a>
</div>

<nav class="tabs">
  <a href="{{ route('referensi.index') }}" @class(['on' => ! request('status')])>Semua ({{ $counts->sum() }})</a>
  @foreach(\App\Models\Referensi::STATUS as $k => $v)
    <a href="{{ route('referensi.index', ['status' => $k]) }}" @class(['on' => request('status') === $k])>{{ $v }} ({{ $counts[$k] ?? 0 }})</a>
  @endforeach
</nav>

<form class="find" method="get" action="{{ route('referensi.index') }}">
  <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul, kata kunci, metode, permasalahan, catatan, atau tag" aria-label="Cari referensi">
  @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
  <button class="btn">Cari</button>
</form>

@forelse($items as $r)
  <article class="item s-{{ $r->status }}">
    <h2><a href="{{ route('referensi.show', $r) }}">{{ $r->judul }}</a></h2>
    <p>
      <span class="st">{{ \App\Models\Referensi::STATUS[$r->status] ?? $r->status }}</span>
      <span class="mute">{{ collect([$r->penulis, $r->tahun])->filter()->join(', ') }}</span>
    </p>
    @if($r->kata_kunci)<p><b>Kata kunci:</b> {{ \Illuminate\Support\Str::limit($r->kata_kunci, 140) }}</p>@endif
    @if($r->permasalahan)<p><b>Masalah:</b> {{ \Illuminate\Support\Str::limit($r->permasalahan, 140) }}</p>@endif
    @if($r->metode)<p><b>Metode:</b> {{ \Illuminate\Support\Str::limit($r->metode, 140) }}</p>@endif
    @foreach($r->tagList() as $t)<a class="chip" href="{{ route('referensi.index', ['tag' => $t]) }}">{{ $t }}</a>@endforeach
  </article>
@empty
  <p class="empty">Belum ada referensi yang cocok. Pilih Tambah referensi untuk mencatat jurnal pertama Anda.</p>
@endforelse

<div class="pager">
  @if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">Sebelumnya</a>@endif
  @if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya</a>@endif
</div>
@endsection
