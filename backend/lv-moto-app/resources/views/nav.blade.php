<div class="nav">
    <div class="navbar-brand">Motor Commerce</div>
    <div class="navbuttons">
        <x-navbutton text="Home" icon="bi bi-house" route="/" />
        <x-navbutton text="Store" icon="bi bi-bag" route="/store" />
        <x-navbutton text="Cart" icon="bi bi-cart" route="/cart" />
    </div>
    @if(!Auth::check())
        <div class="login-reg">
            <a href="{{ ("login") }}">Login</a>
            <a href="{{ ("register") }}">Register</a>
        </div>
    @else
        <x-userinfo />
    @endif
</div>