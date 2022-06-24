@extends('page')

@section('title')
    Register
@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/login.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    <form method="post" action="{{url('confirmRegister')}}" class="login-form">
        {{ csrf_field() }}
        <span>Email</span>
        <input placeholder="example@gmail.com" name="email" type="text">
        <span>Username</span>
        <input placeholder="Username" name="username" type="text">
        <span>Full name</span>
        <input placeholder="John Doe" name="name" type="text">
        <span>Display Name</span>
        <input placeholder="John_Doe" name="displayname" type="text">
        <span>Birthday</span>
        <input name="birthday" type="date">
        <span>Password</span>
        <input placeholder="Password" name="password" type="password">
        <span>Confirm Password</span>
        <input placeholder="Confirm Password" name="confirmPassword" type="password">
        @if(isset ($errors) && count($errors) > 0)
            <div class="alert alert-warning" role="alert">
                <ul class="list-unstyled mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <button type="submit">Sign Up</button>
        <p>All the fields are required</p>
    </form>
@endsection