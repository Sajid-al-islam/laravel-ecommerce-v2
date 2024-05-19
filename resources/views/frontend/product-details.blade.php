@extends('frontend.layouts.app',[
    'meta' => [
        "title" => isset($product->product_name) ? $product->product_name :  "",
        "image" => isset($product->related_images[0]['image']) ? url('') . '/' . $product->related_images[0]['image'] : "",
        "og_image" => isset($product->related_images[0]['image']) ? url('') . '/' . $product->related_images[0]['image'] : "",
        "twitter_image" => isset($product->related_images[0]['image']) ? url('') . '/' . $product->related_images[0]['image'] : "",
        "description" => $product->meta_decription ?? "",
        "price" => isset($product->sales_price) ? $product->sales_price : "" ,
        "keywords" => isset($product->search_keywords) ? $product->search_keywords : ""
    ],
])
@section('content')
<main class="main-content">
    <script src="https://ctgcomputer.com/contents/website/plugins/lightbox/lightbox.min.js"></script>
    <link rel="stylesheet" href="https://ctgcomputer.com/contents/website/plugins/lightbox/lightbox.min.css">
    @if (isset($product))
    <div class="product-detail-area pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="breadcrumb">
                        <li>
                            <a href="/"><i class="fa fa-home" title="Home"></i></a>
                        </li>
                        <li >
                            <a href="">
                                <span>product</span>
                            </a>
                        </li>
                        @php
                            $category_names = "";
                        @endphp
                        @foreach ($product->related_categories as $item)
                            @php
                                $params = [
                                    "id" => $item->id,
                                    "category_name" => str_replace(' ', '-', strtolower($item->name))
                                ];
                                $category_names .= (" ".Str::slug($item->name));
                            @endphp
                            <li >
                                <a href="{{ route('category_product', $params) }}">
                                    <span >{{ $item->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li >
                            <a href="#">
                                {{-- <span>{{$product->product_url}}</span> --}}
                                <span>{{mb_strimwidth($product->product_url,0,20,' .....')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                   <script>
                        // fbq('track', 'AddToCart', {currency: "BDT", value: {{$product->sales_price}}});
                        function fb_purchase(){
                            if(typeof fbq != 'function') return;
                            // fbq('track', 'Purchase', {
                            //     id:"1062700004978868",
                            //     contents: [
                            //         {
                            //             id: '{{$product->id}}',
                            //             quantity: 1 ,
                            //             name: '{{Str::slug($product->product_name)}}',
                            //             product_catalog_id: '704397884547431',
                            //             category: "{{$category_names}}",
                            //             currency: 'BDT',
                            //             value: '{{$product->sales_price}}',
                            //         }
                            //     ],
                            //     content_ids: ['{{$product->id}}'],
                            //     content_type: 'product',
                            //     value: '{{$product->sales_price}}',
                            //     currency: 'BDT',
                            // })
                        }
                        function fb_add_to_cart(){
                            if(typeof fbq != 'function') return;
                            // fbq('track', 'AddToCart', {
                            //     id:"1062700004978868",
                            //     contents: [
                            //         {
                            //             id: '{{$product->id}}',
                            //             quantity: 1 ,
                            //             name: '{{Str::slug($product->product_name)}}',
                            //             product_catalog_id: '704397884547431',
                            //             category: "{{$category_names}}",
                            //             currency: 'BDT',
                            //             value: '{{$product->sales_price}}',
                            //         }
                            //     ],
                            //     content_ids: ['{{$product->id}}'],
                            //     content_type: 'product',
                            //     value: '{{$product->sales_price}}',
                            //     currency: 'BDT',
                            // })
                        }

                        if(typeof fbq == 'function'){
                            // fbq('track', 'ViewContent', {
                            //     id:"1062700004978868",
                            //     contents: [
                            //         {
                            //             id: '{{$product->id}}',
                            //             quantity: 1 ,
                            //             name: '{{Str::slug($product->product_name)}}',
                            //             product_catalog_id: '704397884547431',
                            //             category: "{{$category_names}}",
                            //             currency: 'BDT',
                            //             value: '{{$product->sales_price}}',
                            //         }
                            //     ],
                            //     content_ids: ['{{$product->id}}'],
                            //     content_type: 'product',
                            //     value: '{{$product->sales_price}}',
                            //     currency: 'BDT',
                            // })
                        }
                    </script>
                    <div itemscope itemtype="{{url('')}}/product">
                        <meta itemprop="brand" content="dibyo-bd">
                        <meta itemprop="name" content="{{$product->product_name}}">
                        <meta itemprop="description" content="{{$product->product_name}}">
                        <meta itemprop="productID" content="{{$product->id}}">
                        <meta itemprop="url" content="{{url()->full()}}">
                        <meta itemprop="image" content="{{ $product->related_images[0]['image_link'] }}">
                        <div itemprop="value" itemscope itemtype="http://schema.org/PropertyValue">
                            <span itemprop="propertyID" content="{{$category_names}}"></span>
                            <meta itemprop="value" content="{{$category_names}}"></meta>
                        </div>
                        <div itemprop="offers" itemscope itemtype="{{url('')}}">
                            <link itemprop="availability" href="{{url('')}}">
                            <link itemprop="itemCondition" href="{{url('')}}">
                            <meta itemprop="price" content="{{$product->sales_price}}">
                            <meta itemprop="priceCurrency" content="BDT">
                        </div>
                    </div>
                 <!--<img src="https://www.facebook.com/tr?id=964585464637191&amp;ev=ViewContent&amp;cd[content_name]={{Str::slug($product->product_name)}}&amp;cd[content_category]={{$category_names}}&amp;cd[content_type]=product&amp;cd[content_ids]={{$product->id}}&amp;cd[product_catalog_id]=704397884547431&amp;cd[value]={{$product->sales_price}}&amp;cd[currency]=BDT&amp;noscript=1" height="1" width="1" style="display:none"/>-->

                <div class="col-md-5">

                    <div class="product-detail-thumb me-lg-6">
                        <div>
                            <a href="{{ $product->related_images[0]['image_link'] }}" data-lightbox="roadtrip" data-title="{{ $product->product_name }}">
                                <img id="zoom1"
                                style="width: 100%"
                                src="{{ $product->related_images[0]['image_link'] }}"
                                alt="{{ $product->product_name }}">
                            </a>
                        </div>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom single-product-active text-center mt-2" id="gallery_01">
                            @foreach ($product->related_images as $key=>$item)
                            <li class="d-inline">
                                <a href="{{ $item['image_link'] }}" data-lightbox="roadtrip" data-title="{{ $product->product_name }}">
                                    <img
                                    class="img-thumbnail"
                                    style="cursor:pointer; margin: 5px;" width="90px"
                                    src="{{ $item['image_link'] }}" alt="{{ $product->product_name }}">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="product-detail-content">
                        <h2 class="product-detail-title">{{ $product->product_name }}</h2>

                        <table class="product-info-table">
                            <tbody>
                                @if ($product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now())
                                    <tr class="product-info-group">
                                        <td class="product-info-label">Price</td>
                                        <td class="product-info-data product-price">
                                            {{ number_format($product->sales_price-$product->discounts['discount_amount']) }}৳
                                        </td>
                                    </tr>
                                @endif
                                @if (is_numeric($product->sales_price))
                                    <tr class="product-info-group">
                                        <td class="product-info-label">Regular Price</td>
                                        <td class="product-info-data product-regular-price">{{ number_format($product->sales_price) }}৳</td>
                                    </tr>
                                @endif
                                @if (is_numeric($product->sales_price) && is_numeric($product->stocks_sum_qty) && number_format($product->stocks_sum_qty) > 0)
                                    <tr class="product-info-group">
                                        <td class="product-info-label">Status</td>
                                        <td class="product-info-data product-status">In Stock</td>
                                    </tr>
                                @endif
                                <tr class="product-info-group">
                                    <td class="product-info-label">Product Code</td>
                                    <td class="product-info-data product-code">{{$product->id}}</td>
                                </tr>
                                @if($product->product_brand)
                                    <tr class="product-info-group" itemprop="brand" itemtype=""
                                        itemscope="">
                                        <td class="product-info-label">Brand</td>
                                        <td class="product-info-data product-brand" itemprop="name">
                                            {{ $product->product_brand->name}}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        @if (!is_numeric($product->sales_price))
                            <div class="product-detail-price-string mt-2">{{ $product->sales_price }}</div>
                        @endif

                        <div class="product-detail-review">
                            @if ($product->reviews->avg('star') > 0)
                            <div class="product-detail-review-icon">
                                @for ($i = 0; $i < floor($product->reviews->avg('star')); $i++)
                                    <i class="fa fa-star"></i>
                                    @endfor
                                    @for ($j = $i; $j < 5; $j++) @if ($j==$i && fmod($product->reviews->avg('star'),
                                        $i))
                                        <i class="fa fa-star-half-o"></i>
                                        @else
                                        <i class="fa fa-star-o"></i>
                                        @endif
                                    @endfor
                            </div>
                            <p class="product-detail-review-show"> {{ $product->reviews->avg('star') }} ( {{
                                $product->reviews->count() }} Review )</p>
                            @endif
                        </div>


                        @if ($product->short_description)
                            {{-- <h5>Key features</h6> --}}
                            <div class="product_details_short_description">
                                {!! $product->short_description !!}
                            </div>
                        @endif

                        <div class="mb-3 mt-3">
                            <h5>Price</h6>
                            <div class="cart_price">
                                @php
                                    $has_discount = $product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now();
                                @endphp
                                @if ($has_discount)
                                    <del>{{ number_format($product->sales_price) }}৳</del>
                                    &nbsp;
                                    ৳ {{ number_format($product->sales_price-$product->discounts['discount_amount']) }}
                                @else
                                    {{ number_format($product->sales_price) }}৳
                                @endif
                            </div>
                            @if (!empty($product->sizes()))
                            <div class="product_size">
                                <b>
                                    Select Size:
                                </b>
                                <ul>
                                    @foreach ($product->sizes()->get() as $size)
                                    <li onclick="select_size(`{{ $size->value->title }}`)">
                                        {{ $size->value->title }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="pro-qty">
                                <button onclick="cart_qty.value=(+cart_qty.value-1>0?+cart_qty.value-1:1)">-</button>
                                <input type="number" title="Quantity" id="cart_qty" min="1" value="1">
                                <button onclick="cart_qty.value=+cart_qty.value+1">+</button>
                            </div>
                            {{-- @if ($product->stocks_sum_qty - $product->sales_sum_qty <= $product->low_stock)
                                <span class="me-4 mb-4 stock_alert">Out of stock</span>
                            @else
                                <button onclick="addToCart({{ $product->id }}, +cart_qty.value)" class="product-detail-cart-btn" type="button">Add to cart</button>
                            @endif --}}
                            @if($product->is_upcomming)
                                <button type="button" disabled class="product-detail-cart-btn mb-4">Up comming</button>
                            @elseif ($product->is_tba)
                                <button type="button" disabled class="product-detail-cart-btn mb-4">TBA</button>
                            @elseif ($product->is_pre_order)
                                <button type="button" disabled class="product-detail-cart-btn mb-4">Pre Order</button>
                            @elseif (!$product->is_in_stock)
                                <button type="button" disabled class="product-detail-cart-btn mb-4">Out of stock</button>
                            @else
                                <button type="button"
                                    onclick="addToCart({{$product->id}}, +cart_qty.value)"
                                    class="product-detail-cart-btn mb-4">
                                    Add to cart
                                </button>
                            @endif
                            <button type="button"
                                onclick="buy_now({{$product->id}}, +cart_qty.value);"
                                class="active product-detail-cart-btn mb-4">
                                Buy Now
                            </button>
                        </div>

                        <!--== End Features Area Wrapper ==-->
                        <ul class="product-detail-meta mb-5">
                            <li><b>Share: </b></li>
                            <a class="product-detail-cart-btn share_btn" target="_blank" href="https://www.facebook.com/sharer.php?u={{ url()->full() }}">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a class="product-detail-cart-btn share_btn" target="_blank" href="https://twitter.com/intent/tweet?url={{ url()->full() }}">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="background: #f2f4f8">
        <div class="container">

            <!--== Start Product Detail Tab Area Wrapper ==-->
            <div class="row">
                <div class="col-md-9">
                    <div class="nav product-detail-nav bg-light" id="product-detail-nav-tab" role="tablist">
                        <a href="#specification" class="product-detail-nav-link active">Specification</a>
                        <a href="#description" class="product-detail-nav-link">Description</a>
                        <a href="#review" class="product-detail-nav-link">Review</a>
                    </div>
                    <div class="tab-content" id="product-detail-nav-tabContent">
                        <div class="tab-pane fade show active mb-4" >
                            <h3 class="my-4" id="specification">Specification</h3>

                            <div class="product-detail-nav-description bg-white p-4">
                                {!! $product->specification !!}
                            </div>


                            <h2 class="my-4" id="description">Description</h2>

                            <div class="product-detail-nav-description bg-white p-4">
                                {!! $product->description !!}
                            </div>

                        </div>

                        {{-- <div class="tab-pane" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                            <ul class="product-detail-info-wrap">
                                <li><span>Weight :</span> 250 g</li>
                                <li><span>Dimensions :</span>10 x 10 x 15 cm</li>
                                <li><span>Materials :</span> 60% cotton, 40% polyester</li>
                                <li><span>Other Info :</span> American heirloom jean shorts pug seitan letterpress</li>
                            </ul>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius velit corporis quo voluptate culpa
                                soluta, esse accusamus, sunt quia omnis amet temporibus sapiente harum quam itaque libero
                                tempore. Ipsum, ducimus. lorem</p>
                        </div> --}}

                        <div class="d-none" id="review">
                            <div class="card border-light my-5">
                                <div class="card-body">
                                    <h2 class="my-4">Reviews</h2>

                                    @guest
                                        <p>Login for submit your reviews</p>
                                        <a href="/login">login here</a>
                                    @endguest
                                    @auth
                                        <div class="card border-light mb-4">
                                            <div class="card-body">
                                                <form id="review-form" onsubmit="reviewSubmit(event)" method="post">
                                                    <div class="form-group">
                                                        <label for="">your rating</label>
                                                        <input type="hidden" name="rating" id="rating">
                                                        <input type="hidden" value="{{ $product->id }}" name="product_id"
                                                            id="product_id">
                                                        <ul class="d-flex gap-1">
                                                            <li><i data-serial="1" class="review_star fa fa-star"></i></li>
                                                            <li><i data-serial="2" class="review_star fa fa-star"></i></li>
                                                            <li><i data-serial="3" class="review_star fa fa-star"></i></li>
                                                            <li><i data-serial="4" class="review_star fa fa-star"></i></li>
                                                            <li><i data-serial="5" class="review_star fa fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reviewInput">your review</label>
                                                        <textarea type="text" name="review_description" id="review_description"
                                                            class="form-control" id="reviewInput"
                                                            aria-describedby="reviewInputHelp"></textarea>
                                                    </div>
                                                    <button type="submit" class="my-3 btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endauth

                                    @foreach ($product->reviews as $item)
                                    <div class="product-review-item">
                                        <div class="product-review-top">
                                            <div class="product-review-thumb">
                                                @if (isset($item->user) && $item->user->photo)
                                                    <img src="/{{ $item->user->photo }}" width="64" alt="Images">
                                                @else
                                                    <img src="{{ asset('/avatar.png') }}" width="64" alt="Images">
                                                @endif
                                            </div>
                                            <div class="product-review-content">
                                                <h4 class="product-review-name">{{ $item->user->first_name . " " . $item->user->last_name }}</h4>
                                                {{-- <h5 class="product-review-designation">Delveloper</h5> --}}
                                                <div class="product-review-icon">
                                                    @for ($i = 0; $i < $item->star; $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <p class="desc">{{ $item->review_description }}</p>

                                        @if (Auth::user() && $item->creator == Auth::user()->id)
                                            <button type="button" onclick="remove_review({{$item->id}})" class="review-reply" data-bs-toggle="tooltip" data-bs-placement="top" title="Undo review"><i class="fa fa-undo"></i></button>
                                        @endif
                                    </div>
                                    @endforeach

                                    {{-- <div class="product-review-item">
                                        <div class="product-review-top">
                                            <div class="product-review-thumb">
                                                <img src="{{ asset('contents/frontend') }}/assets/images/shop/details/c1.png"
                                                    alt="Images">
                                            </div>
                                            <div class="product-review-content">
                                                <h4 class="product-review-name">Tomas Doe</h4>
                                                <h5 class="product-review-designation">Delveloper</h5>
                                                <div class="product-review-icon">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra
                                            amet, sodales faucibus nibh. Vivamus amet potenti ultricies nunc gravida duis.
                                            Nascetur scelerisque massa sodales egestas augue neque euismod scelerisque viverra.
                                        </p>
                                        <button type="button" class="review-reply"><i class="fa fa fa-undo"></i></button>
                                    </div> --}}

                                </div>
                            </div>

                        </div>
                    </div>
                    <!--== End Product Detail Tab Area Wrapper ==-->
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>

        <script>
            var elements = document.getElementsByClassName("review_star");
                var selected_star = 0;
                for(var i = 0; i < elements.length; i++){
                    elements[i].addEventListener("mouseover", function () {
                        for (var i = 0; i < elements.length; i++) {
                            elements[i].style.color = "gray";
                        }
                        selected_star = this.dataset.serial;
                        for (let index = 0; index < selected_star; index++) {
                            elements[index].style.color = 'orange';
                        }
                        document.getElementById('rating').value = selected_star;
                    });
                }

                // });
        </script>
        <script>
            // ReviewFunctions();
        </script>
    </div>

    <script>
        // var widths = window.innerWidth;
        // if(widths > 768){
            // $("#zoom1").elevateZoom({
            //     zoomWindowFadeIn : 500,
            //     zoomLensFadeIn: 500,
            //     gallery: "gallery_01",
            //     imageCrossfade: true,
            //     zoomWindowWidth:200,
            //     zoomWindowHeight:200,
            //     zoomWindowOffetx: 10,
            //     scrollZoom: true,
            //     cursor:"pointer",
            //     easyZoom:true,
            //     easing:true,
            //     responsive:true,
            //     lensSize: 10,
            //     // cursor:"url('http://sobujdiganta.com/images/sample3.png'),auto",
            // });

            // $("#img_01").bind("click", function(e) {
            //     var ez =   $('#img_01').data('elevateZoom');
            //     $.fancybox(ez.getGalleryList());
            //     return false;
            // });
        // }
    </script>
    <style>
        .ratings .fa.fa-star{
            color: #f5ba00;
            display: inline-block;
            padding: 1px 2px;
            cursor: pointer;
        }
        .zoomLens{
            /* cursor: url('http://sobujdiganta.com/images/sample3.png'),auto !important; */
            /* background: url('https://laajim.com//hover.png') !important; */

        }
        .zoomWindow{
            border: 0 !important;
            z-index: 999999;
            box-shadow: 0px 0px 10px rgba(0,0,0,.5);
        }
        .input-group{
            z-index: 0;
        }

        @media (min-width:992px) and (max-width:1199.99px){
            .zoomWindow{
                width: 270px !important;
                height: 300px !important;
            }
            .zoomWrapper img{
                width: 290px !important;
                height: 290px !important;
            }
        }
        @media (min-width:1200px){
            .zoomWindow{
                width: 488px !important;
                height: 400px !important;
                top: -30px !important;
            }
            .zoomWrapper{
                width: 300px !important;
                height: 313px !important;
            }
            .zoomWrapper img{
                width: 300px !important;
                height: 313px !important;
            }
        }

        @media (min-width:768px) and (max-width:991.99px){
            .zoomWindow{
                top: 210px !important;
                left: 0px !important;
            }
            .zoomWrapper img{
                width: 200px !important;
                height: 200px !important;
            }
        }
    </style>
    @endif
</main>
@endsection
