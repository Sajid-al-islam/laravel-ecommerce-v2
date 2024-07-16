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
        @include('frontend.include.meta', [
            'meta' => $meta ?? [],
        ])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <!-- Font CSS -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;family=Work+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;display=swap"
            rel="stylesheet">

        <!-- Vendor CSS (Bootstrap & Icon Font) -->
        <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/vendor/bootstrap.min.css">

        <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.carousel.min.css">
        <link rel="stylesheet"
            href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.theme.default.min.css">
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


        {{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TX7BSJHT');</script> --}}


        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '846010664062728');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=846010664062728&ev=PageView&noscript=1" />
        </noscript>
        @stack('custom_js')
    </head>

    <body class="wrapper home-five-wrapper">
        <!-- Google Tag Manager (noscript) -->
        {{-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TX7BSJHT" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript> --}}
        <!-- End Google Tag Manager (noscript) -->

        @include('frontend.layouts.header')

        @if ($setting->breaking_news)
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
                                    <img src="/{{ $setting->footer_logo }}" alt="Logo" width="182" height="31">
                                </a>
                                <div class="widget-contact widget-contact-two">
                                    <p class="widget-contact-desc me-n1">
                                        {{ $setting->footer_short_description }}
                                        @for ($i = 1; $i <= 3; $i++)
                                            @php
                                                $key = 'email_' . $i;
                                            @endphp
                                            @if ($setting->$key)
                                                <a href="mailto://{{ $setting->$key }}">{{ $setting->$key }}</a>
                                            @endif
                                        @endfor
                                    </p>
                                    <div class="widget-info-item mb-6">
                                        <img src="{{ asset('contents/frontend') }}/assets/images/icons/pin.png"
                                            alt="Icon">
                                        <p>
                                            {{ $setting->address }}
                                        </p>
                                    </div>
                                    <div class="widget-info-item">
                                        <img src="{{ asset('contents/frontend') }}/assets/images/icons/mobile.png"
                                            alt="Icon">
                                        <div class="info-item-call">
                                            @for ($i = 1; $i <= 3; $i++)
                                                @php
                                                    $key = 'phone_number_' . $i;
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

        <!--== End Product Quick Wishlist Modal ==-->



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
            //
        </script>

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
