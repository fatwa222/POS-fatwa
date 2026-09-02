@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
@include('layouts.navbar')

<div class="container py-4">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Panggil form produk (bukan form user) --}}
        @include('produk._form')
    </form>
</div>
@endsection