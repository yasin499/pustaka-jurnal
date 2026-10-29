@extends('layouts.app')
@php $baru = ! $jurnal->exists; @endphp
@section('title', $baru ? 'Tambah jurnal' : 'Ubah jurnal')
@section('content')
<h1>{{ $baru ? 'Tambah jurnal target' : 'Ubah jurnal target' }}</h1>
<form method="post" action="{{ $baru ? route('jurnal.store') : route('jurnal.update', $jurnal) }}">
  @csrf
  @unless($baru) @method('PUT') @endunless

  <label for="nama">Nama jurnal</label>
  <input id="nama" name="nama" value="{{ old('nama', $jurnal->nama) }}" required>
  <label for="url">Tautan jurnal</label>
  <input id="url" name="url" type="url" value="{{ old('url', $jurnal->url) }}">

  <div class="grid">
    <div><label for="jenis_biaya">Jenis biaya</label>
      <select id="jenis_biaya" name="jenis_biaya">
        @foreach(['belum_diketahui' => 'Belum diketahui', 'gratis' => 'Gratis', 'berbayar' => 'Berbayar'] as $k => $v)
          <option value="{{ $k }}" @selected(old('jenis_biaya', $jurnal->jenis_biaya) === $k)>{{ $v }}</option>
        @endforeach
      </select></div>
    <div><label for="biaya">Biaya (Rupiah)</label>
      <input id="biaya" name="biaya" type="number" min="0" value="{{ old('biaya', $jurnal->biaya) }}">
      <small>Isi jika berbayar.</small></div>
    <div><label for="periode_terbit">Periode terbit</label>
      <input id="periode_terbit" name="periode_terbit" value="{{ old('periode_terbit', $jurnal->periode_terbit) }}">
      <small>Misalnya: Maret, Agustus, September</small></div>
    <div><label for="indeks">Indeks</label>
      <input id="indeks" name="indeks" value="{{ old('indeks', $jurnal->indeks) }}">
      <label><input type="checkbox" name="indeks_terverifikasi" value="1" @checked(old('indeks_terverifikasi', $jurnal->indeks_terverifikasi))>Indeks sudah saya cek ke sumber resmi</label></div>
  </div>

  <label for="catatan">Catatan</label>
  <textarea id="catatan" name="catatan">{{ old('catatan', $jurnal->catatan) }}</textarea>

  <p>
    <button class="btn">Simpan</button>
    <a class="btn alt" href="{{ route('jurnal.index') }}">Batal</a>
  </p>
</form>
@endsection
