@extends('layouts.app')
@section('title', 'Jurnal target')
@section('content')
<div class="head">
  <h1>Jurnal target publikasi</h1>
  <a class="btn" href="{{ route('jurnal.create') }}">Tambah jurnal</a>
</div>

@if($items->isEmpty())
  <p class="empty">Belum ada jurnal target. Catat biaya, periode terbit, dan indeks agar mudah dibandingkan.</p>
@else
<div class="scroll">
<table>
  <thead><tr><th>Jurnal</th><th>Biaya</th><th>Periode terbit</th><th>Indeks</th><th>Referensi</th><th></th></tr></thead>
  <tbody>
  @foreach($items as $j)
    <tr>
      <td>@if($j->url)<a href="{{ $j->url }}" target="_blank" rel="noopener">{{ $j->nama }}</a>@else{{ $j->nama }}@endif
        @if($j->catatan)<br><small>{{ $j->catatan }}</small>@endif</td>
      <td>{{ $j->biayaLabel() }}</td>
      <td>{{ $j->periode_terbit ?: '-' }}</td>
      <td>{{ $j->indeks ?: '-' }}@if($j->indeks)<br><small>{{ $j->indeks_terverifikasi ? 'Terverifikasi' : 'Belum terverifikasi' }}</small>@endif</td>
      <td>{{ $j->referensis_count }}</td>
      <td>
        <a href="{{ route('jurnal.edit', $j) }}">Ubah</a>
        <form class="inline" method="post" action="{{ route('jurnal.destroy', $j) }}" onsubmit="return confirm('Hapus jurnal target ini?')">
          @csrf @method('DELETE')<button class="link bad">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
@endif
@endsection
