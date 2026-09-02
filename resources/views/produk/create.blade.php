@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')


<form action="{{ route('produk.store') }}"
      method="POST"
      enctype="multipart/form-data">
      @include('Produk._form')
</form>
@endsection