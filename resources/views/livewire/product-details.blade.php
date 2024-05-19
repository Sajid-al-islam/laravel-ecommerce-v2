<div>
    {{-- Stop trying to control. --}}
    <style>
        .stock_alert {
            line-height: 22px;
            font-size: 17px;
            font-weight: 600;
            color: #ef4a23;
        }

        .product-detail-content span {
            color: black !important;
        }

        .product-detail-nav-description span {
            color: black !important;
        }
    </style>
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
                        @foreach ($product->related_categories as $item)
                            @php
                                $params = [
                                    "id" => $item->id,
                                    "category_name" => str_replace(' ', '-', strtolower($item->name))
                                ];
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
                <div class="col-md-5">

                    <div class="product-detail-thumb me-lg-6">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <img id="zoom1"
                            style="width: 100%"
                            src="{{ $product->related_images[0]['image_link'] }}"
                            data-zoom-image="{{ $product->related_images[0]['image_link'] }}"
                            alt="{{$product->product_name}}">
                        </div>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom single-product-active text-center mt-2" id="gallery_01">
                            @foreach ($product->related_images as $key=>$item)
                            <li class="d-inline">
                                <a href="#" class="elevatezoom-gallery {{$key==0?"active":""}}" data-update="" data-image="{{ $item['image_link'] }}" data-zoom-image="{{ $item['image_link'] }}">
                                    <img
                                    style="cursor:pointer; margin: 5px;" width="90px"
                                    src="{{ $item['image_link'] }}" alt="zo-th-1">
                                </a>
                            </li>
                            @endforeach
                        </ul>                                                                                                                                                                                                    </ul>
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
                            <h5>Short Details</h6>
                            <div class="">
                                {!! $product->short_description !!}
                            </div>
                        @endif

                        <div class="mb-3 mt-3">
                            <h5>Add to Cart</h6>
                            <div class="pro-qty">
                                <button onclick="cart_qty.value=(+cart_qty.value-1>0?+cart_qty.value-1:1)">-</button>
                                <input type="number" title="Quantity" id="cart_qty" min="1" value="1">
                                <button onclick="cart_qty.value=+cart_qty.value+1">+</button>
                            </div>
                            @if ($product->stocks_sum_qty - $product->sales_sum_qty <= $product->low_stock)
                                <span class="me-4 mb-4 stock_alert">Out of stock</span>
                            @else
                                <button onclick="addToCart({{ $product->id }}, +cart_qty.value)" class="product-detail-cart-btn" type="button">Add to cart</button>
                            @endif
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

                        <div class="tab-pane" id="review">

                            <button type="button" id="login_modal" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                login/register
                            </button>


                            <div class="card border-light mt-5">
                                <div class="card-body">
                                    <h2 class="my-4">Reviews</h2>

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

                                    @livewire('review', ['product_id' => $product->id])

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
        $("#zoom1").elevateZoom({
            zoomWindowFadeIn : 500,
            zoomLensFadeIn: 500,
            gallery: "gallery_01",
            imageCrossfade: true,
            zoomWindowWidth:200,
            zoomWindowHeight:200,
            zoomWindowOffetx: 10,
            scrollZoom: true,
            cursor:"pointer",
            easyZoom:true,
            easing:true,
            responsive:true,
            lensSize: 10,
            // cursor:"url('http://sobujdiganta.com/images/sample3.png'),auto",
        });

        $("#img_01").bind("click", function(e) {
            var ez =   $('#img_01').data('elevateZoom');
            $.fancybox(ez.getGalleryList());
            return false;
        });
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
</div>
