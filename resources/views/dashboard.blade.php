<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirinkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Login')

<!-- batas awal isi konten -->
@section('content')


    <h1>Dashboard</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

<!-- batas akhir isi konten -->
@endsection