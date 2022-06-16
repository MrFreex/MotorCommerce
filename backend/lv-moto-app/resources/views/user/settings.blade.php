@extends("page")

@section("title")
    Profile Settings
@endsection

@push("styles")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/settings-form.css')}}">
@endpush

@section("content")
    <div class="us-form-rows">
        @if(isset ($errors) && count($errors) > 0)
                <div class="alert alert-warning" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        @if(session("success"))
            <div class="alert alert-success" role="alert">
                {{session("success")}}
            </div>
        @endif
    </div>
    <form method="post" action="{{url('userSettings/apply')}}">
        {{ csrf_field() }}
        <h2>User Settings</h2>
        <div class="us-form-rows">
            <h3>Personal Data</h3>
            <div class="us-grid">
                @foreach($availableSettings as $setting)
                    <x-us-input-field :mandatory="$setting->mandatory" :formname="$setting->name" :inputtype="$setting->type" :name="$setting->label" :value="$setting->value" />
                @endforeach
            </div>
            
            <button type="submit" name="action">Update Settings</button>
            <span class="mandatory-warn">The fields marked with * are mandatory</span>
        </div>
        
    </form>
    <form method="post" action="{{url('userSettings/changePassword')}}">
        {{ csrf_field() }}
        <div class="us-form-rows">
            <h3>Security</h3>
            <div class="us-grid" style="grid-template-columns: auto auto">
                <x-us-input-field :mandatory="true" formname='old_password' inputtype="password" name="Old Password" value="" />
                <div></div>
                <x-us-input-field :mandatory="true" formname='password' inputtype="password" name="New Password" value="" />
                <x-us-input-field :mandatory="true" formname='confirm_password' inputtype="password" name="Confirm Password" value="" />
            </div>
            <button type="submit" name="action">Update Password</button>
            <span class="mandatory-warn">The fields marked with * are mandatory</span>
        </div>
    </form>
    
@endsection