@extends("admin.pages.user-form")

@section("formTitle")
    Edit User {{$user->username}}
@endsection

@section("backurl"){{ route("admin.users") }}@endsection

@section("action")
    {{route("admin.users.confirmEdit", $user->id)}}
@endsection

@section("formContent")
    @foreach($availableSettings as $setting)
        <div class="form-field">
            <span @if($setting->mandatory) class="mandatory" @endif >{{ $setting->label }}</span>
            <input type="{{$setting->type}}" value="{{$setting->value}}" name="{{$setting->name}}" placeholder="{{$setting->label}}" />
        </div>
    @endforeach
    <div class="form-field">
        <span>Password</span>
        <input type="password" name="password" placeholder="********" />
    </div>
@endsection

@section("submitText")
    Update
@endsection

