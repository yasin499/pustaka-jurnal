@extends('layouts.app')
@php $daftar = request()->routeIs('register'); @endphp
@section('title', $daftar ? 'Daftar' : 'Masuk')
@section('content')
<div class="auth">
  <h1>{{ $daftar ? 'Buat akun' : 'Masuk' }}</h1>
  <form method="post" action="{{ $daftar ? route('register') : route('login') }}">
    @csrf
    @if($daftar)
      <label for="name">Nama</label>
      <input id="name" name="name" value="{{ old('name') }}" required>
    @endif
    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    <label for="password">Kata sandi</label>
    <input id="password" name="password" type="password" required>
    @if($daftar)
      <label for="password_confirmation">Ulangi kata sandi</label>
      <input id="password_confirmation" name="password_confirmation" type="password" required>
    @else
      <label><input type="checkbox" name="ingat" value="1">Ingat saya</label>
    @endif
    <p><button class="btn">{{ $daftar ? 'Daftar' : 'Masuk' }}</button></p>
  </form>
  <p class="mute">
    @if($daftar) Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    @else Belum punya akun? <a href="{{ route('register') }}">Daftar</a> @endif
  </p>
</div>
@endsection
