@extends('layouts.app')

@section('title', 'Edit User')

@section('content')


<form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('users._form')
</form>
@endsection