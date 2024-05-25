@extends('frontend.layouts.app', [
    'meta' => [
        'title' => 'checkout',
    ],
])
@section('content')
    <section>
        <div class="container">
            <ul class="breadcrumb pt-4">
                <li>
                    <a href="/"><i class="fa fa-home" title="Home"></i></a>
                </li>
                <li>
                    <a href="/cart">
                        <span>cart</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>checkout</span>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <main class="main-content">
        <link rel="stylesheet" href="/css/select2.css">
        <script src="/js/select2.js"></script>
        {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
        <div class="pt-2 section-space shop-checkout-area">
            <div class="container">
                <h2 class="py-5">Checkout</h2>

                <form class="checkout-content" id="checkout-form" onsubmit="checkout(event)" method="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="card checkout-section checkout-box h-100">
                                <div class="section-head">
                                    <h2><span>1</span>Customer Information</h2>
                                </div>
                                <div class="address">
                                    @php
                                        $address = (object) [];
                                        // $address = \App\Models\OrderAddress::where('user_id',auth()->user()->id)->orderBy('id','DESC')->first();
                                    @endphp
                                    <div class="multiple-form-group">
                                        <div class="form-group mb-2">
                                            <label class="control-label" for="input-firstname">Full Name <sub
                                                    class="text-danger h6">*</sub></label>
                                            <input onkeyup="set_checkout_info()" class="form-control" value="{{ $address->first_name ?? '' }}"
                                                name="first_name" type="text" id="input-firstname"
                                                placeholder="Full Name" />
                                        </div>
                                        {{-- <div class="form-group mb-2">
                                        <label class="control-label" for="input-lastname">Last Name</label>
                                        <input type="text"  value="{{$address->last_name ?? ''}}" id="input-lastname" name="last_name" class="form-control" placeholder="Last Name*" />
                                    </div> --}}
                                    </div>


                                    <div class="form-group mb-2">
                                        <label class="control-label" for="input-telephone">Mobile <sub
                                                class="text-danger h6">*</sub></label>
                                        <input type="text" onkeyup="set_checkout_info()" value="{{ $address->mobile_number ?? '' }}"
                                            id="input-telephone" name="mobile_number" class="form-control"
                                            placeholder="Mobile" />
                                    </div>
                                    <div class="form-group mb-2 d-none" for="input-email">
                                        <label class="control-label">Email</label>
                                        <input type="email" onkeyup="set_checkout_info()" value="{{ $address->email ?? '' }}" id="input-email"
                                            name="email" class="form-control" placeholder="E-Mail" />
                                    </div>
                                    <div class="multiple-form-group">
                                        {{-- <div class="form-group mb-2" for="divisions">
                                            <label class="control-label">
                                                Division
                                                <sub class="text-danger h6">*</sub>
                                            </label>
                                            <div>
                                                <select onchange="set_checkout_info()" id="divisions" name="divisions" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2" for="districts">
                                            <label class="control-label">District <sub
                                                    class="text-danger h6">*</sub></label>
                                            <div>
                                                <select onchange="set_checkout_info()" id="districts" name="districts" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2 d-none" for="police_stations">
                                            <label class="control-label">
                                                Police Stations
                                            </label>
                                            <div>
                                                <input onkeyup="set_checkout_info()" type="text" name="police_stations" class="form-control">

                                            </div>
                                        </div> --}}
                                        {{-- <div class="form-group mb-2" for="upazilas">
                                        <label class="control-label">Upazila</label>
                                        <div>
                                            <select id="upazilas" name="upazilas" class="form-control"></select>
                                        </div>
                                    </div> --}}
                                        {{-- <div class="form-group mb-2" for="unions">
                                        <label class="control-label">Union</label>
                                        <div>
                                            <select id="unions" name="unions" class="form-control"></select>
                                        </div>
                                    </div> --}}
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="control-label" for="input-address">
                                            Address
                                            <sub class="text-danger h6">*</sub>
                                            <sub class="mt-2 d-block">( eg: baily road, 16A, house 34, 4th floor )</sub>
                                        </label>
                                        {{-- <input type="text" value="{{$address->address ?? ''}}" id="input-address" name="address" class="form-control" placeholder="Address*" /> --}}
                                        <textarea onkeyup="set_checkout_info()" class="form-control" name="address" placeholder="address" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="control-label">Comment</label>
                                        <textarea onkeyup="set_checkout_info()" class="form-control" name="comment" placeholder="Comment" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="row row-payment-delivery-order">
                                <div class="col-md-12 col-lg-6 col-sm-12 payment-methods">
                                    <div class="card checkout-section checkout-box h-100">
                                        <div class="section-head">
                                            <h2><span>2</span>Payment Method</h2>
                                        </div>
                                        <div class="">
                                            <p>Select a payment method</p>
                                            <label class="radio-inline">
                                                <input type="radio" onchange="change_cod()" id="cod_btn"
                                                    name="payment_method" value="cod" checked />
                                                Cash on Delivery
                                            </label>
                                            <br />
                                            {{-- <label class="radio-inline">
                                            <input type="radio" onchange="change_bkash()" id="bkash_btn" name="payment_method" value="bkash" />
                                            Bkash
                                        </label>
                                        <br /> --}}
                                            {{-- <label class="radio-inline">
                                            <input type="radio" onchange="change_bank_transfer()" id="bank_transfer_btn" name="payment_method" value="bank" />
                                            Bank Transfer
                                        </label>
                                        <br /> --}}
                                            {{-- <div id="bkash_section" class="border border-1 rounded-1 my-2 p-2 d-none">
                                            <p class="mb-3">
                                                অনুগ্রহ করে আপনার বিকাশ ‘পেমেন্ট অপশন’ থেকে আপনার পেমেন্ট কমপ্লিট করুন। তারপর নিচের ফর্মটি ফিলাপ করুন। আমাদের বিকাশ একাউন্টে টাকা পাঠানোর নিয়মঃ
                                            </p>
                                            <ul class="mb-3">
                                                <li class="d-flex gap-2"><span>১।</span> <span>*247# ডায়াল করে বিকাশ মোবাইল মেন্যুতে যান</span></li>
                                                <li class="d-flex gap-2"><span>২।</span> <span>"Payment" অপশন সিলেক্ট করুন।</span></li>
                                                <li class="d-flex gap-2"><span>৩।</span> <span>Enter Merchant Bkash account এ নিচের নাম্বারটি লিখুন</span></li>
                                                <li class="d-flex gap-2"><span>৪।</span> <span> Amount এ আপনার বিল এমাউন্টটি লিখুন।</span></li>
                                                <li class="d-flex gap-2"><span>৫।</span> <span>Enter Reference এ আপনার নামের প্রথম শব্দ লিখুন।</span></li>
                                                <li class="d-flex gap-2"><span>৬।</span> <span>Enter counter number এ 1 লিখুন।</span></li>
                                                <li class="d-flex gap-2"><span>৭।</span> <span>আপনার বিকাশ মোবাইল মেন্যু পিনটি দিয়ে লেনদেনটি সম্পন্ন করুন।</span></li>
                                                <li class="d-flex gap-2">
                                                    <div>
                                                        <b>bKash Agent No : </b> <br>
                                                    </div>
                                                    <div>
                                                        <b onclick="bkash_number.value=`{{$setting->bkash_number1}}`">{!! $setting->bkash_number1 ? $setting->bkash_number1 . "<br>":'' !!}</b>
                                                        <b onclick="bkash_number.value=`{{$setting->bkash_number2}}`">{!! $setting->bkash_number2 ? $setting->bkash_number2 . "<br>":'' !!}</b>
                                                        <b onclick="bkash_number.value=`{{$setting->bkash_number3}}`">{!! $setting->bkash_number3 ? $setting->bkash_number3 . "<br>":'' !!}</b>
                                                    </div>
                                                </li>
                                                <div class="form-group">
                                                    <label class="control-label" for="input-firstname"><b>BKash Number: </b></label>
                                                    <input class="form-control" name="bkash_number" type="text" id="bkash_number" placeholder="013******" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="input-firstname"><b>BKash transaction ID: </b></label>
                                                    <input class="form-control" name="bkash_trx_id" type="text" id="bkash_trx" placeholder="TRX-4548" />
                                                </div>
                                            </ul>
                                        </div> --}}

                                            {{-- <div id="bank_section" class="border border-1 rounded-1 my-2 p-2 d-none">
                                            <p class="mb-3">
                                                Please go to your personal bank or log into your online banking portal, and follow the guideline:
                                            </p>
                                            <ul class="mb-3">
                                                <li class="d-flex gap-2"><span>1।</span> <span>specify that you would like to send your funds to another bank account,
                                                    and provides the bank account details obtained when they submitted the order.</span></li>
                                                <li class="d-flex gap-2"><span>2।</span> <span>Send the funds and the bank transfer has been initiated.</span></li>
                                                <li class="d-flex gap-2"><span>3।</span> <span>The payment is complete when we payment reaches the receiving account.</span></li>
                                                <li class="d-flex gap-2"><span>4।</span> <span>Provide us the transaction ID</span></li>
                                                <div class="form-group">
                                                    <label class="control-label" for="input-firstname"><b>Bank account no: </b></label>
                                                    <input class="form-control" name="bank_account_no" type="text" id="bank_ac_no" placeholder="013******" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="input-firstname"><b>Transaction ID: </b></label>
                                                    <input class="form-control" name="bank_transaction_id" type="text" id="bank_trx_no" placeholder="TRX-4548" />
                                                </div>
                                            </ul>
                                        </div> --}}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-sm-12 delivery-methods">
                                    <div class="card checkout-section">
                                        <div class="section-head">
                                            <h2><span>3</span>Delivery Method</h2>
                                        </div>
                                        <div class="">
                                            <p>Select a delivery method</p>
                                            <label class="radio-inline">
                                                <input id="home_delivery" type="radio" checked
                                                    onchange="shipping_cost.innerHTML=`{{ $home_delivery_value }}`; total_cost.innerHTML=`{{ $home_delivery_value + $cart_total }}`;"
                                                    name="shipping_method" value="home_delivery" />
                                                Inside Dhaka - {{ $home_delivery_value }} ৳
                                            </label>
                                            <br />
                                            {{-- <br />
                                        <label class="radio-inline">
                                            <input type="radio" onchange="shipping_cost.innerHTML=0; total_cost.innerHTML=`{{$cart_total}}`;" checked name="shipping_method" value="pickup" />
                                            Store Pickup - 0 ৳
                                        </label> --}}
                                            <label class="radio-inline">
                                                <input id="outside_dhaka" type="radio"
                                                    onchange="shipping_cost.innerHTML=`{{ $sub_area_delivery_value }}`; total_cost.innerHTML=`{{ $sub_area_delivery_value + $cart_total }}`;"
                                                    name="shipping_method" value="outside_dhaka" />
                                                Dhaka Sub area (Gazipur, Naraynganj) - {{ $sub_area_delivery_value }} ৳
                                            </label>
                                            <br />
                                            <label class="radio-inline">
                                                <input id="outside_dhaka" type="radio"
                                                    onchange="shipping_cost.innerHTML=`{{ $outside_dhaka_value }}`; total_cost.innerHTML=`{{ $outside_dhaka_value + $cart_total }}`;"
                                                    name="shipping_method" value="outside_dhaka" />
                                                Outside Dhaka - {{ $outside_dhaka_value }} ৳
                                            </label>
                                            <br />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 d-none">
                                    <div class="checkout-section card checkout-box voucher-coupon mt-3 p-1">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12" id="gift-voucher">
                                                    <div class="input-group">
                                                        <input type="text" name="voucher" placeholder="Gift Voucher"
                                                            id="input-voucher" class="form-control" />
                                                        <span class="input-group-btn"><button type="button"
                                                                id="button-voucher" data-loading-text="Loading..."
                                                                class="btn st-outline">Apply Voucher</button></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12" id="discount-coupon">
                                                    <div class="input-group">
                                                        <input type="text" name="coupon"
                                                            placeholder="Promo / Coupon Code" id="input-coupon"
                                                            class="form-control" />
                                                        <span class="input-group-btn"><button type="button"
                                                                id="button-coupon" data-loading-text="Loading..."
                                                                class="btn st-outline">Apply Coupon</button></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 details-section-wrap mt-5">
                                    <div class="card checkout-section checkout-box">
                                        <div class="section-head">
                                            <h2><span>4</span>Order Overview</h2>
                                        </div>
                                        <div class="card-body">
                                            {{-- @dump($carts) --}}
                                            {{-- @dump($carts[0]['product']->categories()->select('name')->first()->name) --}}
                                            @php
                                                $products_ids = '';
                                            @endphp
                                            <script>
                                                function fb_purchase() {
                                                    // fbq('track', 'Purchase', {
                                                    //     id: "1062700004978868",
                                                    //     contents: [
                                                    //         @foreach ($carts as $cart)
                                                    //             @php
                                                    //                 $products_ids .= $cart['product']->id . ',';
                                                    //             @endphp {
                                                    //                 id: '{{ $cart['product']->id }}',
                                                    //                 quantity: {{ $cart['qty'] }},
                                                    //                 name: '{{ $cart['product']->product_name }}',
                                                    //                 product_catalog_id: '1062700004978868',
                                                    //                 category: "{{ $cart['product']->categories()->select('name')->first()->name ?? 't-shirt' }}",
                                                    //                 currency: 'BDT',
                                                    //                 value: '{{ $cart['product']->sales_price }}',
                                                    //             },
                                                    //         @endforeach
                                                    //     ],
                                                    //     content_ids: [{{ $products_ids }}],
                                                    //     content_type: 'product',
                                                    //     currency: 'BDT',
                                                    // })
                                                }
                                            </script>
                                            <table class="table table-bordered bg-white checkout-data">
                                                <thead>
                                                    <tr>
                                                        <td>Product Name</td>
                                                        {{-- <td>Size</td> --}}
                                                        <td>Price</td>
                                                        <td class="text-end">Total</td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ($carts)
                                                        @foreach ($carts as $cart)
                                                            <tr>
                                                                <td class="name">
                                                                    <a
                                                                        href="javascript:void(0)">{{ $cart['product']->product_name }}</a>
                                                                    <div class="options"></div>
                                                                </td>
                                                                {{-- <td>
                                                                    {{ $cart['variant'] }}
                                                                </td> --}}
                                                                <td class="price">
                                                                    <span>{{ $cart['price'] }}৳</span>
                                                                    <span> x </span> <span>{{ $cart['qty'] }}</span>
                                                                </td>
                                                                <td class="price text-end">
                                                                    {{ $cart['price'] * $cart['qty'] }}৳
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    <tr class="total">
                                                        <td colspan="2" class="text-end"><strong>Sub-Total:</strong>
                                                        </td>
                                                        <input type="hidden" name="cart_total"
                                                            value="{{ $cart_total }}" id="cart_total">
                                                        <td class="text-end"><span
                                                                class="amount">{{ $cart_total }}৳</span></td>
                                                    </tr>
                                                    <tr class="total">
                                                        <td colspan="2" class="text-end"><strong>Delivery:</strong>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="amount">
                                                                <span id="shipping_cost">{{ $shipping_method }}</span>৳
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    {{-- @dump($setting) --}}
                                                    @php
                                                        $check_offer = $setting->discount_on_greater_amount > 0 && $cart_total >= $setting->discount_on_greater_amount;
                                                        $discount = floor(($cart_total + $shipping_method) * $setting->discount_on_greater_tk / 100 );
                                                    @endphp
                                                    @if ($check_offer)
                                                        <tr class="total">
                                                            <td colspan="2  " class="text-end">
                                                                <strong>Discount: {{ $setting->discount_on_greater_title }}</strong>
                                                            </td>
                                                            <td class="text-end">
                                                                <span class="amount">
                                                                    <span id="shipping_cost"> - {{ $discount }}</span>৳
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr class="total">
                                                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                                        <input type="hidden" name="order_total" value="{{ $cart_total }}" id="order_total">
                                                        <td class="text-end">
                                                            <span class="amount" id="total_cost">
                                                                @if ($check_offer)
                                                                    {{ $cart_total + $shipping_method - $discount  }}
                                                                @else
                                                                    {{ $cart_total + $shipping_method  }}
                                                                @endif
                                                            </span>৳
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <div class="checkout-final-action mt-3">
                                        <div class="agree-text" style="margin-bottom: 10px;">
                                            {{-- <input type="checkbox" name="agree" value="1" checked="checked" />
                                            I have read and agree to the
                                            <a href="#">
                                                <b>Terms and Conditions</b>
                                            </a>,
                                            <a href="#">
                                                <b>Privacy Policy</b>
                                            </a> and
                                            <a href="#">
                                                <b>Refund and Return Policy</b>
                                            </a> --}}
                                        </div>
                                        @if (count($carts))
                                            <button id="button-confirm" class="btn submit-btn pull-right" type="submit">Confirm
                                                Order</button>
                                        @else
                                            <a class="btn submit-btn pull-right" href="/">No product found in the cart!</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <script defer>
                    setTimeout(async () => {
                        await init_division();
                    }, 600);
                </script>
            </div>
        </div>
    </main>
@endsection
