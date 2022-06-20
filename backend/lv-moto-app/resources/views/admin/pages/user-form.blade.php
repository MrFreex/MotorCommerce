@extends("admin.adminpage")

@push("styles")
    <link rel="stylesheet" href={{asset("css/admin/users.css")}}>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    <div class="title-adduser">
        <div>
            <h2>@yield("formTitle")</h2>
            <p>Fill the fields below to proceed</p>
        </div>
        <div>
            <button onclick="window.location='{{ route('admin.users') }}'"><i class="fa-solid fa-arrow-left"></i> Back</button>
        </div>

        
    </div>
    <div class="float-el">
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
        <form enctype="multipart/form-data" method="post" action="@yield("action")">
            {{ csrf_field() }}
            <div class="form-grid">
                @yield("formContent")
            </div>
            
            <button type="submit">@yield("submitText")</button>
        </form>
    </div>
@endsection