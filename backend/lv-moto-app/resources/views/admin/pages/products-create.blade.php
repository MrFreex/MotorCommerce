@extends("admin.adminpage")

@section("title")
    Create Product
@endsection

@push("styles")
    <link rel="stylesheet" href="{{asset("css/admin/products.css")}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

{{ $isEdit = !empty($product) }}

@section("content")
    <h2>@if($isEdit) {{ $title }} @else Create Product @endif</h2>
    <div class="inner-content">
        <div class="flex">
            <div class="carousel">
                <div class="carousel-pics">
                    <div class="carousel-plus">
                        <input type="file" name="carousel_pic_add" id="carousel_pic_add" />
                        <i class="fa fa-plus"></i>
                    </div>
                    <img style="display: none" id="active-image">
                </div>
                <div class="carousel-slider">
                    <button class="color-plus"><i class="fa fa-plus"></i></button>
                    @if ($isEdit)
                        {{  $product['images'] }}
                        @foreach($product['images'] as $key => $value)
                            <button></button>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="flex-col prod-base-info grow">
                <div class="flex">
                    <input id="prod-title" class="grow" @if ($isEdit) value="{{$product['title']}}" @endif placeholder="Product Title">
                    <input id="prod-cost" type="number" @if ($isEdit) value="{{$product['cost']}}" @endif placeholder="Cost">
                    <input id="prod-code" type="number" @if ($isEdit) value="{{$product['code']}}" @endif placeholder="Code">
                </div>
                <textarea id="prod-desc"  class="grow" placeholder="Description">@if ($isEdit) {{$product['description']}} @endif</textarea>
            </div>
        </div>

        <div class="prod-info grow">
            <div class="flex-col">
                <div class="inp-f">
                    <span class="mandatory">Stock</span>
                    <div id="stock" class="grid-2">
                        <select style="margin-bottom: 2vh;" class="grow">
                            <option value="a">Available</option>
                            <option @if($isEdit && is_numeric($product['stock'])) selected="selected" @endif value="l">Limited</option>
                            <option @if($isEdit && $product['stock'] == false) selected="selected" @endif value="u">Unavailable</option>
                        </select>
                        <input type="number" placeholder="10" @if($isEdit && is_numeric($product['stock'])) value="{{$product['stock']}}" @endif>
                    </div>
                </div>
                <div class="inp-f">
                    <span class="mandatory">Colors (right click to remove)</span>
                    <div id="prod-colors">
                        @if ($isEdit)
                            @foreach($product['colors'] as $color)
                                <div>
                                    <input value="{{$color}}" type="color">
                                </div>
                            @endforeach
                        @endif
                        <div class="color-plus">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-col">
                <div class="flex">
                    <div class="inp-f grow right1">
                        <span>Discount</span>
                        <select id="discount-sel">
                            <option value="d">Disabled</option>
                            <option @if($isEdit && !empty($product['discount']) && is_numeric($product['discount'])) selected="selected" @endif value="a">Active</option>
                        </select>
                    </div>
                    <div class="inp-f">
                        <span>Discounted Cost</span>
                        <input @if($isEdit && !empty($product['discount'] && is_numeric($product['discount']))) value="{{$product['discount']}}" @endif id="discount-inp" style="text-align: center" type="number" name="title" placeholder="10.99" />
                    </div>
                </div>
                <div class="inp-f">
                    <span class="mandatory">Sizes</span>
                    <div id="prod-sizes">
                        @if($isEdit)
                            @foreach($product['sizes'] as $size)
                                <div>
                                    <input type="text" name="title" value="{{$size['title']}}">
                                    <select>
                                        <option value="a">Available</option>
                                        <option @if (is_numeric($size['stock'])) selected="selected" @endif value="l">Limited</option>
                                        <option @if ($size['stock'] == false) selected="selected" @endif value="u">Unavailable</option>
                                    </select>
                                    <input @if(is_numeric($size['stock'])) value="{{$size['stock']}}" @endif type="number">
                                    <i class="fa-solid fa-times"></i>
                                </div>
                            @endforeach
                        @endif
                        <div class="size-plus">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inp-f grow">
                <span>Tags (separated by comas)</span>
                <textarea class="grow" name="tags"></textarea>
            </div>
        </div>
        <div class="flex" style="justify-content: right; margin-top: 4vh;">
            <button id="submit" class="grow">@if (!empty($confirmText)) {{$confirmText}} @else Create @endif</button>
        </div>
    </div>

@endsection

@push("scripts")
    <script>
        const catID = '{{$category}}'


        @if(empty($product))
            let loadedImages = [];
        @else
            let loadedImages = JSON.parse("{{json_encode($product['images'])}}");
        @endif




        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const selectImage = (e) => {
            let img = loadedImages[e];
            if (e >= 0) {
                $(".carousel-pics .carousel-plus").hide();
                $("#active-image").show();
                $("#active-image").attr("src", img);
            } else {
                $("#active-image").hide();
                $(".carousel-pics .carousel-plus").show();
            }
        }

        $(() => {
            if ($("#stock select").val() != "l") {
                $("#stock input").attr("disabled", true);
            }

            const caroHandler = (v) => {
                if($(v.target).hasClass("color-plus")) {
                    selectImage(-1);
                } else {
                    selectImage($(v.target).index());
                }
            }

            $("#active-image").contextmenu(()  => {
                let index;
                loadedImages = loadedImages.filter((v,k) => {
                    const cond = (v !== $("#active-image").attr("src"));
                    if (!cond) index = k;
                    return cond;
                })

                $(".carousel-slider > button").map((k,v) => {
                    if (k == index) {
                        $(v).detach();
                    }
                })

                selectImage(-1)
            })

            $(".carousel-slider > button").map((k,v) => {
                $(v).off("click", caroHandler)
                $(v).click(caroHandler);
            });

            $("#prod-sizes > *:not(.size-plus)").map((k,v) => {
                if ($(v).find("select").val() != "l") {
                    $(v).find("input[type='number']").attr("disabled", true);
                }
            })

            if ($("#discount-sel").val() == "d") {
                $("#discount-inp").attr("disabled", true);
            }

            $("#carousel_pic_add").change(() => {
                let file = $("#carousel_pic_add")[0].files[0];
                let fd = new FormData();
                fd.append("file", file);
                $.ajax({
                    url : "{{route('admin.product.uploadProdImage')}}",
                    type : 'POST',
                    data : fd,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success : function(data) {
                        $(".carousel-slider > .color-plus").before('<button></button>');
                        $(".carousel-slider > button").map((k,v) => {
                            $(v).off("click", caroHandler)
                            $(v).click(caroHandler);
                        });
                        loadedImages.push(data);
                        selectImage(loadedImages.length - 1);
                    }
                });
            });
        })

        $("#stock select").change(function(){
            if($(this).val() == "l"){
                $("#stock").find("input[type='number']").prop("disabled", false);
            }else{
                $("#stock").find("input[type='number']").prop("disabled", true);
            }
        });

        const removeSize = function() {
            $(this).parent().remove();
        }

        const sizesCH = function(){
            if($(this).val() !== "l"){
                $(this).parent().find('input[type=\'number\']').prop("disabled", true);
            } else {
                $(this).parent().find('input[type=\'number\']').prop("disabled", false);
            }
        }

        $('#prod-sizes > *:not(.size-plus)').map((k,v) => {
            $(v).find("select").change(sizesCH);
        })

        $('#discount-sel').change(() => {
            if ($("#discount-sel").val() === "a") {
                $("#discount-inp").attr("disabled", false);
            } else {
                $("#discount-inp").attr("disabled", true);
            }
        })

        const removeColor = function(e) {
            e.preventDefault()
            $(this).remove();
        }

        const colorCH = function(){
            $(this).css("background-color", $(this).find("input").val());
        }

        $("#prod-colors > *:not(.color-plus)").map((k,v) => {
            $(v).find("input[type='color']").change(colorCH);
        })

        $("div.color-plus").click((e) => {

            // language=HTML
            $('div.color-plus').before(`
                <div>
                    <input type="color">
                </div>
            `);

            $('#prod-colors > *:not(.color-plus)').map((k,v) => {
                $(v).off("change", colorCH);
                $(v).off("contextmenu", removeColor);
                $(v).change(colorCH);
                $(v).contextmenu(removeColor)
            })
        });

        $(".size-plus").click((e) => {

            // language=HTML
            $('.size-plus').before(`
                <div>
                    <input type="text" name="title" placeholder="S">
                    <select>
                        <option value="a">Available</option>
                        <option value="l">Limited</option>
                        <option value="u">Unavailable</option>
                    </select>
                    <input type="number">
                    <i class="fa-solid fa-times"></i>
                </div>
            `);

            $('#prod-sizes > *:not(.size-plus)').map((k,v) => {
                $(v).find("select").off("change", sizesCH);
                $(v).find("i").off("click", removeSize);
                $(v).find("select").change(sizesCH);
                $(v).find("i").click(removeSize);
            })
        });

        $("#submit").click(function(e) {
            e.preventDefault();
            let form = new FormData();
            form.append("title", $("#prod-title").val());
            form.append("cost", $("#prod-cost").val());
            form.append("code", $("#prod-code").val());

            form.append("description", $("#prod-desc").val());

            let stock = $("#stock select").val();
            switch (stock) {
                case "a": stock = true; break;
                case "u": stock = false; break;
                case "l": stock = $("#stock input").val(); break;
            }

            form.append("stock", stock);
            form.append("images", JSON.stringify(loadedImages));

            let sizes = $("#prod-sizes > *:not(.size-plus)").map((k,v) => {
                let stock = $(v).find("select").val();
                switch (stock) {
                    case "a": stock = true; break;
                    case "u": stock = false; break;
                    case "l": stock = $(v).find("input[type='number']").val(); break;
                }
                let size = {
                    title : $(v).find("input[type='text']").val(),
                    stock : stock
                }
                return size;
            })

            form.append("sizes", JSON.stringify(sizes.toArray()));

            let colors = $("#prod-colors > *:not(.color-plus)").map((k,v) => {
                return $(v).find("input[type='color']").val();
            })

            form.append("colors", JSON.stringify(colors.toArray()));
            form.append("category", catID);

            $.ajax({
                url : "{{route('admin.products.add')}}",
                type : 'POST',
                data : form,
                processData: false,
                contentType: false,
                success : function(data) {
                    window.location.href = "{{route('admin.products')}}";
                }
            });

        });
    </script>
@endpush

