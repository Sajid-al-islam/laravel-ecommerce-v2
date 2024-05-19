<div id="header_block">
    <header class="header_area">
        <div class="header_area_content custom-container">
            <!-- logo_area start -->
            <!-- <div class="col-2"> -->
            <div class="logo_area">
                <a href="/">
                    <img src="/{{$setting->header_logo}}" alt="logo">
                </a>
            </div>
            <!-- </div> -->
            <!-- logo_area end -->
            <!-- search_area start -->
            <div class="search_area">
                <!-- <div class="search_content"> -->
                <form class="w-100" wire:submit.prevent="submitSearchPage">
                    <input wire:model="searchQuery" wire:keyup="search_product" class="form-control" type="text" id="search" placeholder="Search Products" />

                    <button type="submit" class="search_icon">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                @if ($search_products)
                    <div class="search_result">
                        <div class="list-group list-group-flush p-2">
                            @foreach ($search_products as $item)
                                @php
                                    $data = [
                                        "id" => $item->id,
                                        "product_name" => str_replace(' ', '-', strtolower($item->product_name))
                                    ];
                                @endphp
                                <a href="{{ route('product_details', $data) }}" class="d-flex gap-3" style="align-items: flex-start;">
                                    <img src="{{ env('PHOTO_URL') . '/' . $item->related_images[0]['image'] }}" width="80" height="80" style="object-fit: contain;" alt="Image-Ctgcomputer">
                                    <div>
                                        {{ $item->product_name }} <br>
                                        @if (is_numeric($item->sales_price))
                                            {{ $item->sales_price}} ৳
                                        @else
                                            {{ $item->sales_price}}
                                        @endif
                                        <br>
                                        <br>
                                    </div>
                                </a>
                            @endforeach
                            <a href="{{ route('search_product', $searchQuery) }}"
                            class="mt-5 mb-2 active text-center">View more</a>
                        </div>
                    </div>
                @endif
                <!-- </div> -->
            </div>
            <!-- search_area end-->
            <!-- item_area start-->
            <div class="item_area">
                <!--item_1 start -->
                {{-- <div class="item offers">
                    <span href="#">
                        <div class="icon">
                            <i class="fa fa-gift"></i>
                        </div>
                        <div class="title_and_discription">
                            <div class="title">
                                <h2>offers</h2>
                            </div>
                            <div class="discription">
                                <p>latest offers</p>
                            </div>
                        </div>
                    </span>
                </div> --}}
                <!--item_1 end -->

                <!--item_2 start -->
                {{-- <div class="item other">
                    <a href="#">
                        <div class="icon">
                            <i class="fa fa-bolt"></i>
                        </div>
                        <div class="title_and_discription">
                            <div class="title">
                                <h2>item 2</h2>
                            </div>
                            <div class="discription">
                                <p>latest item 2</p>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <!--item_2 end -->

                <!--item_3 start -->
                <div class="item account">
                    <span href="#">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title_and_discription">
                            <div class="title">
                                <h2>account</h2>
                            </div>
                            <div class="discription">
                                <div class="register_and_login">
                                    @auth
                                    <p>
                                        <a href="/profile">Profile</a>
                                    </p>
                                    @else
                                    <p>
                                        <a href="/register" class="register">register</a>
                                        or
                                        <a href="/login" class="login">login</a>
                                    </p>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
                <div class="item account">
                    <span href="#">
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="title_and_discription">
                            <div class="title">
                                <a href="/cart">
                                    <h2>
                                        Carts
                                    </h2>
                                </a>
                            </div>
                            <div class="discription">
                                <div class="register_and_login">
                                    <p>
                                        (
                                            <b class="header_cart_count">
                                                @if(session()->has("carts"))
                                                    {{count(session()->get('carts'))}}
                                                @else
                                                    0
                                                @endif
                                            </b>
                                        )
                                    </p>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
                <!--item_3 end -->
                <!-- button_area start -->
                {{-- <div class="button_area">
                    <a href="#">
                        PC Builder
                    </a>
                </div> --}}
                <!-- button_area end-->
            </div>
            <!-- item_area end-->

            <!-- responsive_header_manu start -->
            <div class="responsive_header_manu">
                <!-- menu_bar start-->
                <a href="#" class="menu_bar" onclick="event.preventDefault() ;document.getElementById('nav_list_items').classList.toggle('active')">
                    <i class="fa fa-align-left"></i>
                </a>
                <!-- menu_bar end-->
                <!-- logo start-->
                <div class="logo">
                    <a href="/">
                        <img src="/{{$setting->header_logo}}" alt="logo">
                    </a>
                </div>
                <!-- logo end-->
                <!-- search_and_card start -->
                <div class="search_and_card">
                    {{-- <a href="jascript:void;" onclick="$('.search_area').toggleClass('active')" class="search_icon">
                        <i class="fa fa-search"></i>
                    </a> --}}

                    <a href="/cart" class="card_icon">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="count">
                            <span class="cart-count header_cart_count">{{ $cart_count }}</span>
                        </span>
                    </a>
                </div>
                <!-- search_and_card end -->
            </div>
            <!--responsive_header_manu end -->
        </div>
    </header>

    <nav id="nav">
        <div class="container custom-container">
            <div id="nav_list" class="active">
                <ul id="nav_list_items">
                    <li onclick="nav_list_items.classList.toggle('active')" class="nav_close">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"
                            ></path>
                        </svg>
                    </li>
                    <li class="home">
                        <div class="nav_title">
                            <a href="/">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 576 512">
                                    <path
                                        d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z"
                                    ></path>
                                </svg>
                            </a>
                        </div>
                    </li>
                </ul>
                <script>
                    function nav_render(nav_html){
                        let li = document.querySelectorAll('#nav_list_items li');
                        [...li].forEach(e=>e.classList.length?'':e.remove())
                        nav_list_items.insertAdjacentHTML('beforeend',nav_html);
                    }
                    if(window.nav_cats?.length){
                        nav_render(window.nav_cats)
                    }else{
                        fetch("/api/v1/nav-categories")
                            .then(res=>res.json())
                            .then(res=>{
                                window.nav_cats = res.html;
                                nav_render(res.html)
                            })
                    }
                </script>
            </div>
        </div>
    </nav>
    <style>
        #nav #nav_list > ul{
            padding: 0;
        }
        #nav #nav_list > ul > li .drop_down2{
            transition-duration: .1s;
        }
        @media (min-width: 992px){
            #nav #nav_list > ul > li .drop_down2{
                max-height: 500px;
                overflow-y:scroll;
            }
        }
        #nav #nav_list > ul > li:hover .drop_down2{}
        #nav #nav_list > ul li a{
            padding: 10px 5px;
        }
    </style>
    <script>
        function show_dropdown(){
            let target = event.currentTarget;
            let drop_down = target.parentNode.parentNode.children[1];
            // [...document.querySelectorAll('.drop_down2 ')].forEach(i=>i.classList.remove('active'))
            if(drop_down){
                drop_down.classList.toggle('active');
                if(drop_down.classList.contains('active')){
                    target.innerHTML = '<i class="fa text-light fa-minus-square-o"></i>'
                }else{
                    target.innerHTML = '<i class="fa text-light fa-plus-square-o"></i>'
                }
            }
        }

        var navs = document.getElementById('nav');
        window.addEventListener('scroll',function(e){
            if(window.scrollY > 143){
                navs.classList.add('nav_fixed');
            }else{
                navs.classList.remove('nav_fixed');
            }
        })
    </script>


    <div class="responsive_header_bottom d-none">
        <div class="responsive_header_bottom_content">

            <a href="#" class="bottom_item gifi">
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="icon_title">
                    <p>Cart</p>
                </div>
            </a>

            @auth
            <a href="/profile" class="bottom_item user">
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="icon_title">
                    <p>Account</p>
                </div>
            </a>
            @else
            <a href="/login" class="bottom_item user">
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="icon_title">
                    <p>Account</p>
                </div>
            </a>
            @endauth
        </div>
    </div>
</div>
