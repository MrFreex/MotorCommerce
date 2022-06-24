<button onclick="window.location='{{ url('admin/'.$route) }}';"  class="adm-navbutton">
    <i class="bi bi-{{$icon}}"></i>
    <div>
        <span>{{$text}}</span>
    </div>
</button>