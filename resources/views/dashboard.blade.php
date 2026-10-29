@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="head">
  <div>
    <h1>Halo, {{ auth()->user()->name }}</h1>
    <p class="mute">
      @if($total) {{ $selesai }} dari {{ $total }} referensi sudah selesai dibaca. @else Belum ada referensi yang tercatat. @endif
    </p>
  </div>
  <a class="btn" href="{{ route('referensi.create') }}">Tambah referensi</a>
</div>

<div class="pies">
  @include('partials.pie', ['title' => 'Status baca', 'data' => $pieStatus, 'empty' => 'Muncul setelah Anda menambah referensi pertama.'])
  @include('partials.pie', ['title' => 'Kelengkapan metode', 'data' => $pieMetode, 'note' => $tanpaSumber.' referensi belum punya PDF atau tautan artikel.', 'empty' => 'Muncul setelah Anda menambah referensi pertama.'])
  @include('partials.pie', ['title' => 'Jurnal target menurut biaya', 'data' => $pieBiaya, 'empty' => 'Muncul setelah Anda menambah jurnal target.'])
</div>

<div class="cols">
  <section class="panel">
    <h2>Lanjutkan membaca</h2>
    <ul>
      @forelse($lanjut as $r)
        <li><a href="{{ route('referensi.show', $r) }}">{{ \Illuminate\Support\Str::limit($r->judul, 80) }}</a></li>
      @empty
        <li class="mute">Tidak ada yang sedang dibaca. Ubah status sebuah referensi menjadi Sedang dibaca.</li>
      @endforelse
    </ul>
  </section>

  <section class="panel">
    <h2>Baru ditambahkan</h2>
    <ul>
      @forelse($terbaru as $r)
        <li><a href="{{ route('referensi.show', $r) }}">{{ \Illuminate\Support\Str::limit($r->judul, 80) }}</a></li>
      @empty
        <li class="mute">Belum ada referensi.</li>
      @endforelse
    </ul>
  </section>

  <section class="panel wide">
    <h2>Jurnal target publikasi</h2>
    <ul>
      @forelse($jurnals as $j)
        <li>{{ $j->nama }} <small>({{ $j->biayaLabel() }}@if($j->periode_terbit), terbit {{ $j->periode_terbit }}@endif)</small></li>
      @empty
        <li class="mute">Belum ada jurnal target.</li>
      @endforelse
    </ul>
    <p><a href="{{ route('jurnal.index') }}">Lihat semua jurnal target ({{ $jurnalTotal }})</a></p>
  </section>
</div>
@endsection
