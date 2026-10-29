@extends('layouts.app')
@php $baru = ! $referensi->exists; @endphp
@section('title', $baru ? 'Tambah referensi' : 'Ubah referensi')
@section('content')
<h1>{{ $baru ? 'Tambah referensi' : 'Ubah referensi' }}</h1>
<form method="post" enctype="multipart/form-data"
      action="{{ $baru ? route('referensi.store') : route('referensi.update', $referensi) }}">
  @csrf
  @unless($baru) @method('PUT') @endunless

  <label for="judul">Judul</label>
  <input id="judul" name="judul" value="{{ old('judul', $referensi->judul) }}" required>

  <div class="grid">
    <div><label for="penulis">Penulis</label>
      <input id="penulis" name="penulis" value="{{ old('penulis', $referensi->penulis) }}"></div>
    <div><label for="tahun">Tahun</label>
      <input id="tahun" name="tahun" type="number" value="{{ old('tahun', $referensi->tahun) }}"></div>
    <div><label for="url_artikel">Tautan artikel</label>
      <input id="url_artikel" name="url_artikel" type="url" value="{{ old('url_artikel', $referensi->url_artikel) }}"></div>
    <div><label for="pdf">File PDF (maks. 20 MB)</label>
      <input id="pdf" name="pdf" type="file" accept="application/pdf">
      @if($referensi->file_pdf)<small>PDF sudah terlampir. Unggah berkas baru untuk menggantinya.</small>@endif</div>
    <div><label for="status">Status baca</label>
      <select id="status" name="status">
        @foreach(\App\Models\Referensi::STATUS as $k => $v)
          <option value="{{ $k }}" @selected(old('status', $referensi->status) === $k)>{{ $v }}</option>
        @endforeach
      </select></div>
    <div><label for="jurnal_target_id">Jurnal target publikasi</label>
      <select id="jurnal_target_id" name="jurnal_target_id">
        <option value="">Tidak ada</option>
        @foreach($jurnals as $j)
          <option value="{{ $j->id }}" @selected((string) old('jurnal_target_id', $referensi->jurnal_target_id) === (string) $j->id)>{{ $j->nama }}</option>
        @endforeach
      </select></div>
  </div>

  <label for="kata_kunci">Kata kunci pencarian</label>
  <input id="kata_kunci" name="kata_kunci" value="{{ old('kata_kunci', $referensi->kata_kunci) }}" placeholder='"Pendataan anak" AND "digitalisasi"'>
  <small>Kata kunci yang Anda ketik di mesin pencari atau database jurnal untuk menemukan artikel ini. Boleh memakai AND, OR, dan NOT.</small>

  <label for="metode">Metode</label>
  <textarea id="metode" name="metode">{{ old('metode', $referensi->metode) }}</textarea>

  <div class="grid">
    <div><label for="kelengkapan_metode">Kelengkapan metode</label>
      <select id="kelengkapan_metode" name="kelengkapan_metode">
        <option value="">Belum dinilai</option>
        @foreach(['lengkap' => 'Lengkap', 'cukup' => 'Cukup', 'kurang' => 'Kurang'] as $k => $v)
          <option value="{{ $k }}" @selected(old('kelengkapan_metode', $referensi->kelengkapan_metode) === $k)>{{ $v }}</option>
        @endforeach
      </select></div>
    <div><label for="relevansi">Relevansi (1 sampai 5)</label>
      <select id="relevansi" name="relevansi">
        <option value="">Belum dinilai</option>
        @for($i = 1; $i <= 5; $i++)
          <option value="{{ $i }}" @selected((string) old('relevansi', $referensi->relevansi) === (string) $i)>{{ $i }}</option>
        @endfor
      </select></div>
  </div>

  <label for="permasalahan">Permasalahan</label>
  <textarea id="permasalahan" name="permasalahan">{{ old('permasalahan', $referensi->permasalahan) }}</textarea>
  <label for="temuan">Temuan atau hasil</label>
  <textarea id="temuan" name="temuan">{{ old('temuan', $referensi->temuan) }}</textarea>
  <label for="keterbatasan">Keterbatasan atau celah penelitian</label>
  <textarea id="keterbatasan" name="keterbatasan">{{ old('keterbatasan', $referensi->keterbatasan) }}</textarea>
  <label for="catatan">Catatan bebas</label>
  <textarea id="catatan" name="catatan">{{ old('catatan', $referensi->catatan) }}</textarea>
  <label for="tags">Tag</label>
  <input id="tags" name="tags" value="{{ old('tags', $referensi->tags) }}">
  <small>Pisahkan dengan koma, misalnya: BPR, UMKM</small>

  <p>
    <button class="btn">Simpan</button>
    <a class="btn alt" href="{{ $baru ? route('referensi.index') : route('referensi.show', $referensi) }}">Batal</a>
  </p>
</form>
@endsection
