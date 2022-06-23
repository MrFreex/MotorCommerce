@extends("admin.adminpage")

@section("title")
    Products
@endsection

@push("styles")
    <link rel="stylesheet" href={{asset("css/admin/users.css")}}>
    <link rel="stylesheet" href={{asset("css/admin/products.css")}}>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section("content")
    <div class="title-adduser">
        <div>
            <h2>Products</h2>
            <p>Products list and categories</p>
        </div>
        <div>
            <button onclick="createCategory()"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>

    @if(session("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif

    <div class="container cat-cont">
        @foreach($categories as $key => $category)
            <div>
                <input type="hidden" value="{{$category['_id']}}">
                <div class="category">
                    <div class="cat-label">{{$category['label']}}</div>
                    <div class="cat-actions">
                        <i onclick="window.location = '{{ route("admin.products.create", $category['_id']) }}'" class="fa-solid fa-plus"></i>
                        <i onclick="renameCat(this)" class="fa-solid fa-pen-to-square"></i>
                        <i onclick="window.location = '{{ route("admin.products.delCategory",$category['_id']) }}'" class="fa-solid fa-trash"></i>
                    </div>
                </div>
                <ul class="products-list collapse show">
                    @foreach($category['products'] as $product)
                        <li>
                            <input type="hidden" value="{{$product['_id']}}">
                            <div>
                                <div><i class="fa-solid fa-bars"></i></div>
                                <div>{{$product['title']}}</div>
                            </div>
                            <div>
                                <div>{{$product['cost']}}</div>
                                <div class="prod-actions">
                                    <i onclick="window.location='{{ route('admin.products.edit', $product['_id']) }}'" class="fa-solid fa-pen-to-square"></i>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <script>
        const createCategory = () => {
            let el = $(".cat-cont").append("<div> <div class='category new-cat'> <input type='text' placeholder='Category Name'> <i class='fa fa-check'></i></div>")
            $(el).find(".new-cat > i").click((e) => {
                const form = new FormData()
                form.set("name", $($(e.target).parent().find("input")).val())
                $.ajax({
                    url : "{{route('admin.products.createCategory')}}",
                    type : 'POST',
                    data : form,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success : function() {
                        window.location.reload();
                    }
                }).catch(() => {
                    alert("The category name must be at least 3 characters long")
                })
            })
        }

        const renameCat = (target) => {
            const el = $(target).parent().parent().find(".cat-label")
            let text = $(el).text()
            $(el).detach()

            $(target).parent().before(`<div> <div class='category new-cat'> <input type='text' value='${text}' r='Category Name'> <i class='fa fa-check'></i></div>`)
            $(target).parent().parent().find(".new-cat i").click((ev) => {
                window.location = '{{ url("/admin/products/renameCat") }}/' + $(target).parent().parent().parent().find("input[type=hidden]").val() + "/" + $(ev.target).parent().find("input").val()
            })

        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(() => {
            $(".cat-cont").map((k,v) => {
                $(v).find(".category").click((e) => {
                    if (!$(e.target).hasClass(".category"))
                        $(e.target).parent().find(".collapse").collapse('toggle');
                })
            })

            $("li").draggable({
                revert: true,
                snap: true
            });
            $(".cat-cont > div").droppable({
                tolerance: "pointer",
                drop: (event, ui) => {
                    console.log($(ui.draggable).find("input[type=hidden]").val())
                    let form = new FormData()

                    form.append("_id", $(ui.draggable).find("input[type=hidden]").val());
                    form.append("newCat", $(event.target).find("input[type=hidden]").val());

                    $.ajax({
                        url : "{{route('admin.products.move')}}",
                        type : 'POST',
                        data : form,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success : function(data) {
                            const el = $(ui.draggable).detach()
                            $(event.target).find("ul").append(el)
                        }
                    })

                }
            })
        })
    </script>
@endsection
