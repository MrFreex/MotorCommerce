<div class="popup-shadow">
    <div class="popup-content">
        <div class="popup-content">
            <div class="popup-title">
                <h2>@yield("p-title")</h2>
                <div class="popup-close">
                    <a href="{{ url("/userProfile/" . $username) }}"><i class="bi bi-x"></i></a>
                </div>
            </div>
            @yield("popup")
        </div>
    </div>
</div>