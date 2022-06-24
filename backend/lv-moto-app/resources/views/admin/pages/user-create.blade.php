@extends("admin.pages.user-form")

@section("formTitle")
    Create User
@endsection

@section("backurl"){{ route("admin.users") }}@endsection

@section("action")
    {{route('admin.user.confirmCreate')}}
@endsection

@section("formContent")
    @foreach($availableSettings as $setting)
        <div class="form-field">
            <span @if($setting->mandatory) class="mandatory" @endif >{{ $setting->label }}</span>
            <input type="{{$setting->type}}" name="{{$setting->name}}" placeholder="{{$setting->label}}" />
        </div>
    @endforeach
    <div class="form-field">
        <span class="mandatory">Password</span>
        <input type="password" name="password" placeholder="********" />
    </div>
@endsection

@section("submitText")
    Create
@endsection