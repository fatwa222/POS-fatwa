@extends('layouts.app')

@section('title', 'Edit Jenis Produk')

@section('content')
@include('layouts.navbar')

<form action="{{ route('jenis.update', $jenis->id) }}" method="POST">
    @method('PUT')
    @include('jenis._form')
</form>
@endsection