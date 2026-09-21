@extends('layouts.app')

@section('title', 'Tambah Jenis Produk')

@section('content')
@include('layouts.navbar')

<form action="{{ route('jenis.store') }}" method="POST">
    @include('jenis._form')
</form>
@endsection