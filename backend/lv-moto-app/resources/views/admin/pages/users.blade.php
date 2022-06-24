@extends("admin.adminpage")

@section("title")
    Users
@endsection

@push("styles")
    <link rel="stylesheet" href={{asset("css/admin/users.css")}}>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    <div class="title-adduser">
        <div>
            <h2>Users</h2>
            <p>User list and management</p>
        </div>
        <div>
            <button onclick="window.location='{{ url('/admin/users/create') }}'"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
    
    @if(session("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif
    <form method="post" action="{{ route("admin.users.search") }}">
        {{ csrf_field() }}
        <input type="text" name="search" placeholder="Search" />
        <select name="field">
            @foreach([ "username" => "Username", "email" => "Email", "phone" => "Phone Number", "displayname" => "Display Name", "name" => "Full Name" ] as $key => $field)
                <option value="{{$key}}">{{$field}}</option>
            @endforeach
        </select>
        <div class="inline-flex">
            <button style="width: unset;" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
            <button type="button" onclick="window.location='{{ url('/admin/users/list') }}'"><i class="fa-solid fa-eraser"></i> Clear</button>
        </div>
    </form>
    
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Display Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->displayname }}</td>
                    <td><a href="mailto:{{$user->email}}">{{ $user->email }}</a></td>
                    <td>{{ $user->permission }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td class="user-actions">
                        <a title="Edit" href="{{ url("admin/users/edit", $user->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a title="View Profile" target="_blank" href="{{ url("/userProfile/" . $user->displayname) }}"><i class="fa-solid fa-user"></i></a>
                        <a title="Login As" target="_blank" href="{{ route("admin.users.loginas", $user->id) }}"><i class="fa-solid fa-user-check"></i></a>
                        <a title="Delete" href="{{ route("admin.users.delete", $user->id) }}"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection