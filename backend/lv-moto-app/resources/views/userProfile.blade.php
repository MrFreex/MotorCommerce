@extends('page')

@section('title')
    {{$userdata->name}}
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
            <div class="userProfile-background">
                <div class="userProfile-changebg">
                    <button onclick="window.location='{{ url('/userProfile/' . $username . '/changeBg') }}'"><i class="bi bi-image"></i></button>
                </div>
                
            </div>
            <div class="userProfile-avatar">
                <div>
                    <div><i class="bi bi-image"></i></div>
                    <img src="{{ asset("avatars/" . $userdata->profileBg) }}" alt="">
                </div>
                <h1>{{$userdata->name}}</h1>
            </div>
        </div>
    </div>
@endsection