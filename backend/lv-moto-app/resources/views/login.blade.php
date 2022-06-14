@extends('page')

@section('title')
    Login
@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/login.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    <form method="post" action="{{url('confirmLogin')}}" class="login-form">
        {{ csrf_field() }}
        <span>Username/Email</span>
        <input placeholder="Username" name="email" type="text">
        <span>Password</span>
        <input placeholder="Password" name="password" type="password">
        <button type="submit">Login</button>
    </form>
@endsection