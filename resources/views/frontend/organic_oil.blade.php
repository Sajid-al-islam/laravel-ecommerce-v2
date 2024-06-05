@extends('frontend.layouts.layout_blank', [
    'meta' => [
        'title' => 'Organic oil',
    ],
])
<style>
    .outlined_btn {
        border: 2px solid {{ !empty($landing_page->secondary_color) ? $landing_page->secondary_color : '#fcd957' }};
        color: {{ !empty($landing_page->secondary_color) ? $landing_page->secondary_color : '#fcd957' }};
        font-size: 20px;
    }

    .outlined_btn:hover {
        border: 2px solid {{ !empty($landing_page->secondary_color) ? $landing_page->secondary_color : '#fcd957' }};
        color: {{ !empty($landing_page->secondary_color) ? $landing_page->secondary_color : '#fcd957' }};
        font-size: 20px;
    }
</style>
@section('content')
    <main class="main-content">
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold">{{ $landing_page->title }}</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">{{ $landing_page->sub_title }}</p>
                        <a class="btn btn-primary btn-xl outlined_btn button-animation"
                            href="#order_section">{{ !empty($landing_page->first_btn_text) ? $landing_page->first_btn_text : 'দ্রুত অর্ডার করতে ক্লিক করুন' }}</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="row">
            @if (!empty($landing_page->video_link))
                <iframe class="utube_video" frameborder="0" allowfullscreen=""
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" width="700" height="500"
                    src="https://www.youtube.com/embed/{{ $landing_page->video_link }}" id="widget2"></iframe>
            @endif
        </section>
        <section class="page-section" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">{{ $landing_page->middle_title }}</h2>
                <div class="d-flex justify-content-center my-5">
                    @php
                        if (!empty($landing_page->image_1) && !empty($landing_page->image_2)) {
                            $both_img_available = true;
                        }
                    @endphp
                    @if (isset($both_img_available) && $both_img_available == true)
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-12">
                                <img width="600" src="/{{ $landing_page->image_1 }}" alt="">
                            </div>
                            <div class="col-sm-6 col-md-6 col-12">
                                <img width="600" src="/{{ $landing_page->image_2 }}" alt="">
                            </div>
                        </div>
                    @elseif (!empty($landing_page->image_1))
                        <img width="600" src="/{{ $landing_page->image_1 }}" alt="">
                    @elseif (!empty($landing_page->image_2))
                        <img width="600" src="/{{ $landing_page->image_2 }}" alt="">
                    @endif
                </div>
                <div class="d-flex justify-content-center">
                    <a href="#order_section" class="btn btn-primary outlined_btn button-animation">অর্ডার করতে ক্লিক
                        করুন!</a>
                </div>
            </div>
        </section>
        {{-- <section class="page-section" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">অর্গানিক তেল ও হেয়ার প্যাক এর উপকারিতা</h2>
                        <hr class="divider divider-light" />
                        <p class="text-white-75 mb-4">চুলের যেকোনো সমস্যার যদি প্রাকৃতিক ভাবে সমাধান করতে চান কোন
                            পার্শ্ব-প্রতিক্রিয়া ছাড়া তাহলে এখনি অর্ডার করুন প্রাকৃতিক প্রায় ৩১ টি উপাদানে তৈরি</p>
                        <a class="btn btn-light btn-xl" href="#services">অর্ডার করতে ক্লিক করুন!</a>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- Services-->
        <section class="page-section bg_with_img" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0 text-white">{{ $landing_page->faq_title }}</h2>
                <hr class="divider" />
                <div class="accordion" id="accordionExample">
                    @foreach ($landing_page->landingFaq as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $key }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}"
                                    aria-expanded="{{ $key == 0 ? true : '' }}"
                                    aria-controls="collapse{{ $key }}">
                                    {{ $faq->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse show"
                                aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $faq->description }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                আমার খুশকির সমস্যা আছে। এই তেল কি খুশকি দূর করবে?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                খুশকি হওয়া চুল পড়ে যাওয়ার প্রধান কারণ। আমার এই তেল নিয়মিত ব্যবহারে খুশকি শতভাগ দূর হবে এবং
                                আপনার চুল পড়ে যাওয়া থেকে রক্ষা পাবে
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                আপনারা কি কোন গ্যারান্টি দেন?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                ১০০% গ্যারান্টির কথা বলা বিক্রির জন্য মিথ্যার আশ্রয় ছাড়া আর কিছুই না। কারণ চুলপড়ার অনেক
                                কারণ থাকতে পারে। অনেকের বংশগত কারণেও চুল পড়ে থাকে। আবার অনেকের প্রোটিনের অভাবে চুল পড়ে।
                                আমরা শতভাগ গ্যারান্টি দিইনা তবে প্রাকৃতিক যেসব উপাদান চুলের জন্য উপকারী এমন প্রায় ৩১ টা
                                উপাদান দিয়ে তেলটি তৈরি করেছি। আমি এবং আরও অনেকে উপকার পেয়েছে। আশা করছি আপনিও উপকার পাবেন।
                                এছাড়াও আমাদের পেইজে আপনি উপকার পেয়েছে এমন মানুষের প্রচুর পরিমাণে রিভিউ দেখতে পাবেন। নিয়ম
                                মেনে ব্যবহার করলে আপনি অবশ্যই উপকার পাবেন
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                কি কি উপদান দিয়ে তৈরি?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                খাটি নারিকেল তেলের সাথে জবা ফুলের নির্যাস, আমলকি, মেথি, ব্রাহ্মি, কারিপাতা, শিকাকাই, রিঠা সহ
                                প্রায় ৩১ টি প্রাকৃতিক উপাদান ব্যবহার করা হয়েছে যা চুলের জন্য অনেক অনেক উপকারী।
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>

        <section class="page-section" id="order_section">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">অর্ডার করতে সঠিক তথ্য দিয়ে নিচের ফর্মটি পূরণ করুন</h2>
                        <hr class="divider" />
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    <div class="col-12">
                        <div class="container">
                            <main id="billing">
                                <form action="{{ route('frontend_checkout') }}" method="POST">
                                    @csrf
                                    <div class="row g-5" style="font-family: 'Hind Siliguri';">
                                        <div class="col-md-6 col-lg-6 order-last">
                                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                <span>Your order</span>
                                            </h4>
                                            <ul class="list-group mb-3" id="cart_section">

                                            </ul>

                                            <div class="card">
                                                <div class="card-header">
                                                    ক্যাশ অন ডেলিভারি
                                                </div>
                                                <div class="card-body">
                                                    পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন
                                                </div>
                                            </div>
                                            <button style="background-color: #116c3c;color: #fff;"
                                                class="w-100 btn btn-primary btn-lg mt-5" type="submit">অর্ডার
                                                কনফার্ম করতে ক্লিক করুন</button>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <h4 class="mb-3">অর্ডার কনফার্ম করতে</h4>

                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    {{ $error }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endforeach

                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="firstName" class="form-label">আপনার নাম
                                                        লিখুন</label>
                                                    <input type="text" name="first_name" class="form-control"
                                                        id="firstName" placeholder="" value="" required="" />
                                                    <div class="invalid-feedback">
                                                        দয়া করে আপনার নাম লিখুন
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="mobile_no" class="form-label">সঠিক মোবাইল
                                                        নাম্বার লিখুন</label>
                                                    <input type="text" name="mobile_number" class="form-control"
                                                        id="mobile_no" placeholder="" required="" />
                                                    <div class="invalid-feedback">
                                                        দয়া করে আপনার মোবাইল নাম্বারটি লিখুন
                                                    </div>
                                                </div>

                                                {{-- <input type="hidden" name="product_id" value="{{ $product->id }}"> --}}
                                                <input type="hidden" name="shipping_method" value="home_delivery">
                                                <input type="hidden" name="payment_method" value="cod">
                                                <input type="hidden" name="delivery_charge" value="0">
                                                <input type="hidden" name="source" value="landing">


                                                <div class="col-12">
                                                    <label for="address" class="form-label">ঠিকানা দিন
                                                        (বাড়ি/গ্রাম, থানা, জেলা)</label>
                                                    <input type="text" name="address" class="form-control"
                                                        id="address" placeholder="" required="" />
                                                    <div class="invalid-feedback">
                                                        দয়া করে আপনার মোবাইল নাম্বারটি লিখুন
                                                    </div>
                                                </div>

                                                <hr class="my-4" />

                                                <h4 class="mb-3">প্রোডাক্ট সিলেক্ট করুন</h4>

                                                @foreach ($landing_page->landingProducts as $key => $productItem)
                                                    @php
                                                        $product = $productItem->product;
                                                    @endphp
                                                    <div class="my-3 border border-dark"
                                                        style="background-color: #f7f7f7;">
                                                        <div class="form-check pt-4">
                                                            <input class="form-check-input" type="radio"
                                                                name="product_id"
                                                                onchange="updateCart({{ $product->id }})"
                                                                id="product_id_{{ $key }}"
                                                                value="{{ $product->id }}"
                                                                {{ $product->id == 66 ? 'checked' : '' }}>

                                                            <label class="form-check-label"
                                                                for="product_id_{{ $key }}">
                                                                <div class="d-flex">
                                                                    <img style="height: 80px;"
                                                                        src="{{ $product->related_images[0]['image_link'] }}"
                                                                        alt="">
                                                                    <div class="pricing ms-3">
                                                                        <h6 style="font-family: arial;" class="fw-bold">
                                                                            {{ $product->product_name }}</h6>
                                                                        <p class="justify">
                                                                            {{ $product->sales_price }} ৳</p>
                                                                    </div>
                                                                </div>
                                                            </label>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                </form>
                            </main>
                        </div>
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-6 text-center mb-5 mb-lg-0">
                        <i class="bi-phone fs-2 mb-3 text-muted"></i>

                        <h5>
                            যেকোন প্রয়োজনে যোগাযোগ করুনঃ
                            01568-095982
                        </h5>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        $(document).ready(function() {
            updateCart(66);
        });
    </script>
@endsection
