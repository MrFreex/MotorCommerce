@extends("popup")

@push("styles")
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("p-title")
    Change Background
@endsection

@section("popup")
    <form class="popup-header" enctype="multipart/form-data" method="post" action="{{url('upload/bg')}}">
        {{ csrf_field() }}
        <span class="inputSpan">Url</span>
        <input name="url" type="text" id="url" placeholder="Url">
        <span class="inputSpan">File</span>
        <input name="file" type="file" id="file" placeholder="File">
        @if(isset ($errors) && count($errors) > 0)
            <div class="alert alert-warning" role="alert">
                <ul class="list-unstyled mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit">Carica</button>
    </form>
@endsection