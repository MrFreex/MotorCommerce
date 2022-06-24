<div class="adm-navbar">
    <div class="navbar-brand">
        <a href="{{url('/')}}">
            <img src="{{asset('logo.png')}}" alt="Logo">
        </a>
        <h3 class="op0">Motor Commerce</h3>
    </div>
    <div class="navbuttons">
        <x-admin.navbutton :route="''" :icon="'speedometer'" :text="'Overview'" />
        <x-admin.navbutton :route="'users/list/'" :icon="'people-fill'" :text="'Users'" />
        <x-admin.navbutton :route="'products/list/'" :icon="'archive-fill'" :text="'Products'" />
        <x-admin.navbutton :route="'orders/list/'" :icon="'bag-fill'" :text="'Orders'" />
        <x-admin.navbutton :route="'payments'" :icon="'currency-dollar'" :text="'Payments'" />
        <x-admin.navbutton :route="'shipments'" :icon="'envelope-fill'" :text="'Shipments'" />
        <x-admin.navbutton :route="'pages'" :icon="'file-earmark-richtext-fill'" :text="'Pages'" />
        <x-admin.navbutton :route="'staff'" :icon="'person-workspace'" :text="'Staff'" />
        <x-admin.navbutton :route="'settings'" :icon="'gear-fill'" :text="'Settings'" />
    </div>
</div>

<script>
    $('.adm-navbar').mouseenter(() => {
        $('.adm-navbar').addClass("nav-open")
    })

    $('.adm-navbar').mouseleave(() => {
        $('.adm-navbar').removeClass("nav-open")
    })
</script>
