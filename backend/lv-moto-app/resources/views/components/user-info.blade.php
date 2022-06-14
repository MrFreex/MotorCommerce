<div class="user-flex">
    <div class="user-info">
        <a href="{{ url('/userProfile/' . $username) }}"><img class="user-avatar" src="{{$avatar}}"></a>
        <span>{{$displayName}}</span>
        <button onclick="window.location='{{ url('/logout') }}'">Logout</button>
        @if ($isAdmin)
            <x-navbutton text="Admin" icon="bi bi-gear-wide-connected" route="/admin" />
        @endif
    </div>
</div>