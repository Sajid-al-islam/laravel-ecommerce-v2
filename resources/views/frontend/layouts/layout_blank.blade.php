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

    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/vendor/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/js/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/plugins/simple-line-icons.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('contents/frontend') }}/landing.css">
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

    <!-- Google Tag Manager -->

    <!-- End Google Tag Manager -->


</head>

<body class="wrapper home-five-wrapper">
    <!-- Google Tag Manager (noscript) -->

    <!-- End Google Tag Manager (noscript) -->



    @if($setting->breaking_news)
        <style>
            .latest_news .marquee_body marquee {
                font-size: 15px;
                line-height: 30px;
                height: 24px;
            }
        </style>
    @endif

    @yield('content')

    <!--== Scroll Top Button ==-->
    <div class="scroll-to-top" onclick="got_to_top();"><span class="fa fa-angle-double-up"></span></div>

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
