@extends('page')

@php {{ $isLogged = auth()->user() && auth()->user()->displayname == $username; }} @endphp

@section('title')
    {{$userdata["name"]}}
@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/userProfile.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    @if($usePopup)
        @include($usePopup)
    @endif
    <div class="userProfile-container">
        <div class="userProfile-header">
            <div class="userProfile-background" style="@if($userdata["profileBg"]) background-image: url({{ asset('/backgrounds/' . $userdata["profileBg"]) }} @endif)">
                <div class="userProfile-changebg">
                    @if($isLogged)
                        <button onclick="window.location='{{ url('/userProfile/' . $username . '/changeBg') }}'"><i class="bi bi-image"></i></button>
                        <button onclick="window.location='{{ url('/userSettings') }}'"><i class="bi bi-gear"></i></button>
                    @endif
                </div>
                <div class="userProfile-avatar">
                    <div>
                        <div style="@if(!$isLogged) opacity:0; cursor: auto; @endif">
                            <a @if($isLogged) href="{{ url("/userProfile/" . $username . '/changeAvatar') }}" @endif>
                                <i class="bi bi-image"></i>
                            </a>
                        </div>
                        <img onerror="this.src='{{ asset("/assets/avatar.png") }}'" src="{{ asset('/avatars/' . $userdata["avatar"]) }}">
                    </div>
                    <h1>{{$userdata["name"]}}</h1>
                </div>
            </div>
           
        </div>
        <div class="userProfile-content">

        </div>
    </div>
@endsection