<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/{{ $setting->fabicon }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    @include('frontend.include.meta',[
        'meta' => $meta??[]
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;family=Work+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;display=swap"
        rel="stylesheet">

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/vendor/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/plugins/simple-line-icons.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/ryns_nav.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/custom.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/vendor/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('contents/frontend') }}/assets/js/plugins/swiper-bundle.min.js"></script> --}}
    <script src="{{ asset('contents/frontend') }}/assets/js/owlcarousel/owl.carousel.min.js"></script>

    <!-- Custom Main JS -->
    <script src="{{ asset('contents/frontend') }}/assets/js/zoom.js"></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/main.js" defer></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/cart.js" defer></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/review.js" defer></script>
    <script src="{{ asset('contents/frontend') }}/assets/js/livewire_hook.js" defer></script>
    <script src="/js/frontend.js" defer></script>



    @include('frontend.layouts.website_style')

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TX7BSJHT');</script>
    <!-- End Google Tag Manager -->

    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1062700004978868');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1062700004978868&ev=PageView&noscript=1"
    /></noscript>
</head>

<body class="wrapper home-five-wrapper">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TX7BSJHT"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include('frontend.layouts.header')

    @if($setting->breaking_news)
        <style>
            .latest_news .marquee_body marquee {
                font-size: 15px;
                line-height: 30px;
                height: 24px;
            }
        </style>
        <div class="latest_news">
            <div class="container custom-container">
                <div class="marquee_body">
                    <marquee>
                        {{ $setting->breaking_news }}
                    </marquee>
                </div>
            </div>
        </div>
    @endif

    @yield('content')

    <footer class="footer-area footer-three-area">
        <div class="container">
            <!--== Start Footer Main ==-->
            <div class="footer-main">
                <div class="row mb-n6">
                    <div class="col-md-6 col-lg-3 mb-6">
                        <div class="widget-item">
                            <a class="widget-logo" href="/">
                                <img src="/{{$setting->footer_logo}}" alt="Logo" width="182" height="31">
                            </a>
                            <div class="widget-contact widget-contact-two">
                                <p class="widget-contact-desc me-n1">
                                    {{ $setting->footer_short_description }}
                                    @for ($i = 1; $i <= 3; $i++)
                                        @php
                                            $key = "email_".$i;
                                        @endphp
                                        @if ($setting->$key)
                                            <a href="mailto://{{$setting->$key}}">{{$setting->$key}}</a>
                                        @endif
                                    @endfor
                                </p>
                                <div class="widget-info-item mb-6">
                                    <img src="{{ asset('contents/frontend') }}/assets/images/icons/pin.png" alt="Icon">
                                    <p>
                                        {{ $setting->address }}
                                    </p>
                                </div>
                                <div class="widget-info-item">
                                    <img src="{{ asset('contents/frontend') }}/assets/images/icons/mobile.png" alt="Icon">
                                    <div class="info-item-call">
                                        @for ($i = 1; $i <= 3; $i++)
                                            @php
                                                $key = "phone_number_".$i;
                                            @endphp
                                            @if ($setting->$key)
                                                <a href="tel://{{ $setting->$key }}">
                                                    {{ $setting->$key }}
                                                </a>
                                            @endif
                                        @endfor

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 offset-lg-1 mb-6">
                        <div class="widget-item">
                            <h4 class="widget-title">Information</h4>
                            <h4 class="widget-title widget-collapsed-title collapsed" data-bs-toggle="collapse"
                                data-bs-target="#widgetTitleId-1">Information</h4>
                            <div id="widgetTitleId-1" class="collapse widget-collapse-body">
                                <ul class="widget-nav">
                                    <li><a href="{{ route('about_us') }}">About us</a></li>
                                    <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('terms_and_condition') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 offset-lg-1 ps-xl-4 mb-6">
                        <div class="widget-item">
                            <h4 class="widget-title">Account</h4>
                            <h4 class="widget-title widget-collapsed-title collapsed" data-bs-toggle="collapse"
                                data-bs-target="#widgetTitleId-2">Account</h4>
                            <div id="widgetTitleId-2" class="collapse widget-collapse-body">
                                <ul class="widget-nav">
                                    <li><a href="{{ route('frontend.profile') }}">My account</a></li>
                                    <li><a href="{{ route('frontend.orders') }}">My orders</a></li>
                                    <li><a href="{{ route('frontend.reviews') }}">My Reviews</a></li>
                                    <li><a href="{{ route('frontend.address') }}">Shipping Address</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 offset-lg-1 ps-xl-0 mb-6">
                        <div class="widget-item">
                            <h4 class="widget-title">Store</h4>
                            <h4 class="widget-title widget-collapsed-title collapsed" data-bs-toggle="collapse"
                                data-bs-target="#widgetTitleId-3">Store</h4>
                            <div id="widgetTitleId-3" class="collapse widget-collapse-body">
                                <ul class="widget-nav">
                                    <li><a href="{{ route('offer_products') }}">Discount</a></li>
                                    <li><a href="/">Latest products</a></li>
                                    <li><a href="/category/47/laptop">All Collection</a></li>
                                    <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--== End Footer Main ==-->

            <!--== Start Footer Bottom ==-->
            <div class="footer-bottom">
                <p class="copyright">© {{ now()->year }} Premium fruit shop
            </div>
            <!--== End Footer Bottom ==-->
        </div>
    </footer>
    <!--== End Footer Area Wrapper ==-->

    <!--== Scroll Top Button ==-->
    <div class="scroll-to-top" onclick="got_to_top();"><span class="fa fa-angle-double-up"></span></div>

    <!--== Start Product Quick Wishlist Modal ==-->
    <aside class="product-action-modal modal fade" id="action-WishlistModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="product-action-view-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="modal-action-messages">
                            <i class="fa fa-check-square-o"></i> Added to wishlist successfully!
                        </div>
                        <div class="modal-action-product">
                            <div class="thumb">
                                <img src="{{ asset('contents/frontend') }}/assets/images/shop/modal1.jpg"
                                    alt="Organic Food Juice" width="466" height="320">
                            </div>
                            <h4 class="product-name"><a href="shop-single-product.html">CRAS NEQUE METUS</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!--== End Product Quick Wishlist Modal ==-->

    <!--== Start Product Quick Add Cart Modal ==-->
    <aside class="product-action-modal modal fade" id="action-CartAddModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="product-action-view-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="modal-action-messages">
                            <i class="fa fa-check-square-o"></i> Added to cart successfully!
                        </div>
                        <div class="modal-action-product">
                            <div class="thumb">
                                <img src="{{ asset('contents/frontend') }}/assets/images/shop/modal1.jpg"
                                    alt="Organic Food Juice" width="466" height="320">
                            </div>
                            <h4 class="product-name"><a href="shop-single-product.html">CRAS NEQUE METUS</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!--== End Product Quick Add Cart Modal ==-->

    <!--== Start Product Quick Add Cart Modal ==-->
    <aside class="product-action-modal modal fade" id="action-CompareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="product-action-view-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="modal-action-messages">
                            <i class="fa fa-check-square-o"></i> Added to compare successfully!
                        </div>
                        <div class="modal-action-product">
                            <div class="thumb">
                                <img src="{{ asset('contents/frontend') }}/assets/images/shop/modal1.jpg"
                                    alt="Organic Food Juice" width="466" height="320">
                            </div>
                            <h4 class="product-name"><a href="shop-single-product.html">CRAS NEQUE METUS</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!--== End Product Quick Add Cart Modal ==-->

    <!--== Start Sidebar Cart Menu ==-->
    <aside class="sidebar-cart-modal offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1"
        id="offcanvasWithCartSidebar">
        <div class="offcanvas-header">
            <button type="button" class="btn-close cart-close" data-bs-dismiss="offcanvas" aria-label="Close">×</button>
        </div>
        <div class="sidebar-cart-inner offcanvas-body">
            <div class="sidebar-cart-content">
                <div class="sidebar-cart-all">
                    <div class="cart-header">
                        <h3>Shopping Cart</h3>
                        <div class="close-style-wrap">
                            <span class="close-style close-style-width-1 cart-close"></span>
                        </div>
                    </div>
                    <div class="cart-content cart-content-padding">
                        <ul>
                            <li class="single-product-cart">
                                <div class="cart-img">
                                    <a href="shop-single-product.html"><img
                                            src="{{ asset('contents/frontend') }}/assets/images/shop/s3.jpg" alt="Image"
                                            width="70" height="67"></a>
                                </div>
                                <div class="cart-title">
                                    <h4><a href="shop-single-product.html">Game Triger Finger New</a></h4>
                                    <span> 1 × <span class="price"> $12.00 </span></span>
                                </div>
                                <div class="cart-delete">
                                    <a href="#/"><i class="pe-7s-trash icons"></i></a>
                                </div>
                            </li>
                            <li class="single-product-cart">
                                <div class="cart-img">
                                    <a href="shop-single-product.html"><img
                                            src="{{ asset('contents/frontend') }}/assets/images/shop/s4.jpg" alt="Image"
                                            width="70" height="67"></a>
                                </div>
                                <div class="cart-title">
                                    <h4><a href="shop-single-product.html">Android Smart Watch XAD0</a></h4>
                                    <span> 1 × <span class="price"> $59.90 </span></span>
                                </div>
                                <div class="cart-delete">
                                    <a href="#/"><i class="pe-7s-trash icons"></i></a>
                                </div>
                            </li>
                        </ul>
                        <div class="cart-total">
                            <h4>Subtotal: <span>$71.90</span></h4>
                        </div>
                        <div class="cart-checkout-btn">
                            <a class="cart-btn" href="shop-cart.html">view cart</a>
                            <a class="checkout-btn" href="shop-checkout.html">checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!--== End Sidebar Cart Menu ==-->

    <!--== Start Aside Search Menu ==-->
    <aside class="aside-search-box-wrapper offcanvas offcanvas-top" data-bs-scroll="true" tabindex="-1"
        id="AsideOffcanvasSearch">
        <div class="offcanvas-header">
            <h5 class="d-none" id="offcanvasTopLabel">Aside Search</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">×</button>
        </div>
        <div class="offcanvas-body">
            <div class="container pt--0 pb--0">
                <div class="search-box-form-wrap">
                    <div class="search-note">
                        <p>Start typing and press Enter to search</p>
                    </div>
                    <form action="#" method="post">
                        <div class="search-form position-relative">
                            <label for="search-input" class="visually-hidden">Search</label>
                            <input id="search-input" type="search" class="form-control"
                                placeholder="Search entire store…">
                            <button class="search-button" type="button"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </aside>
    <!--== End Aside Search Menu ==-->

    <!--== Start Side Menu ==-->
    <aside class="aside-side-menu-wrapper off-canvas-area offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1"
        id="offcanvasWithBothOptions">
        <div class="sidemenu-top">
            <div class="header-top-info">
                <a href="shop.html"><span>World Wide Completely </span>Free Returns and Free Shipping</a>
            </div>
            <div class="header-info-dropdown">
                <button type="button" class="btn-info dropdown-toggle" id="dropdownLang2" data-bs-toggle="dropdown"
                    aria-expanded="false">English</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownLang2">
                    <li class="dropdown-item active">English</li>
                    <li class="dropdown-item">Français</li>
                </ul>
            </div>
            <div class="header-info-dropdown">
                <button type="button" class="btn-info dropdown-toggle" id="dropdownCurrency2" data-bs-toggle="dropdown"
                    aria-expanded="false">USD</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownCurrency2">
                    <li class="dropdown-item active">USD</li>
                    <li class="dropdown-item">EUR</li>
                </ul>
            </div>
        </div>
        <div class="offcanvas-header" data-bs-dismiss="offcanvas">
            <h5>Menu</h5>
            <button type="button" class="btn-close">×</button>
        </div>
        <div class="offcanvas-body">
            <!-- Start Mobile Menu Wrapper -->
            <div class="res-mobile-menu">
                <nav id="offcanvasNav" class="offcanvas-menu">
                    <ul>
                        <li><a href="javascript:void(0)">Home</a>
                            <ul>
                                <li><a href="index.html">Home One</a></li>
                                <li><a href="index-two.html">Home Two</a></li>
                                <li><a href="index-three.html">Home Three</a></li>
                                <li><a href="index-four.html">Home Four</a></li>
                                <li><a href="index-five.html">Home Five</a></li>
                                <li><a href="index-six.html">Home Six</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Shop</a>
                            <ul>
                                <li><a href="javascript:void(0)">Shop Layout</a>
                                    <ul>
                                        <li><a href="shop.html">Shop 3 Column</a></li>
                                        <li><a href="shop-four-columns.html">Shop 4 Column</a></li>
                                        <li><a href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                        <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Single Product</a>
                                    <ul>
                                        <li><a href="shop-single-product.html">Single Product Normal</a></li>
                                        <li><a href="shop-single-product-variable.html">Single Product Variable</a></li>
                                        <li><a href="shop-single-product-group.html">Single Product Group</a></li>
                                        <li><a href="shop-single-product-affiliate.html">Single Product Affiliate</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Others Pages</a>
                                    <ul>
                                        <li><a href="shop-cart.html">Shopping Cart</a></li>
                                        <li><a href="shop-checkout.html">Checkout</a></li>
                                        <li><a href="shop-wishlist.html">Wishlist</a></li>
                                        <li><a href="shop-compare.html">Compare</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Pages</a>
                            <ul>
                                <li><a href="about-us.html">About</a></li>
                                <li><a href="account.html">Account</a></li>
                                <li><a href="login-register.html">Login/Register</a></li>
                                <li><a href="page-not-found.html">Page Not Found</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Blog</a>
                            <ul>
                                <li><a href="blog.html">Blog Grid</a></li>
                                <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                                <li><a href="blog-details-left-sidebar.html">Blog Details Left Sidebar</a></li>
                                <li><a href="blog-details-right-sidebar.html">Blog Details Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact</a></li>
                        <li class="vmenu-menu-item"><a href="javascript:void(0)">All Departments</a>
                            <ul class="vmenu-content">
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm1.png"
                                                alt="Icon"></span> Headphone</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm2.png"
                                                alt="Icon"></span> Video Game</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm3.png"
                                                alt="Icon"></span> Protable Speakers</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm4.png"
                                                alt="Icon"></span> Digital Camera</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm5.png"
                                                alt="Icon"></span> Gadgets</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm6.png"
                                                alt="Icon"></span> Home Appliances</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm7.png"
                                                alt="Icon"></span> Audio Record</a></li>
                                <li class="vmenu-item"><a href="shop.html"> <span class="icon"><img
                                                src="{{ asset('contents/frontend') }}/assets/images/icons/vm8.png"
                                                alt="Icon"></span> Computer/Laptop</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- End Mobile Menu Wrapper -->
        </div>
    </aside>

    <aside class="product-cart-view-modal modal fade" id="action-QuickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="quick_view_product_modal">

                </div>
            </div>
        </div>
    </aside>

    <!--== Wrapper End ==-->

    <!-- Messenger Chat plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
    //   var chatbox = document.getElementById('fb-customer-chat');
    //   chatbox.setAttribute("page_id", "108007495562741");
    //   chatbox.setAttribute("attribution", "biz_inbox");
    // </script>

    <script>
    //   window.fbAsyncInit = function() {
    //     FB.init({
    //       xfbml            : true,
    //       version          : 'v18.0'
    //     });
    //   };

    //   (function(d, s, id) {
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id)) return;
    //     js = d.createElement(s); js.id = id;
    //     js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    //     fjs.parentNode.insertBefore(js, fjs);
    //   }(document, 'script', 'facebook-jssdk'));
    </script>

</body>

</html>
