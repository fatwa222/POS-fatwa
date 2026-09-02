@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')


<form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('users._form')
</form>
@endsection