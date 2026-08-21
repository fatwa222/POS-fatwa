@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h4>Edit User</h4>

<!-- Gunakan method="POST" dan HAPUS baris @method('PUT') -->
<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"> 
    @csrf
    @include('users._form')
</form>
@endsection