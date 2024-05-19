@extends('frontend.layouts.app',[
"meta" => [
"title" => "terms and conditions",
]
])
@section('content')
<main class="main-content">
    <section>
        <div class="container">
            <ul class="breadcrumb pt-4">
                <li>
                    <a href="/"><i class="fa fa-home" title="Home"></i></a>
                </li>
                <li>
                    <a href="#">
                        <span>Product Carts</span>
                    </a>
                </li>
            </ul>
    </section>

    <section style="background: #f2f4f8;">
        <br>
        <br>
        <div class="container ">
            <div class="card">
                <div class="card-body">
                    <div class="product-area section-space">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-table-wrap">
                                        <div class="table-responsive">
                                            <table class="cart-table">
                                                @if (count($carts) > 0)
                                                <thead>
                                                    <tr>
                                                        <th class="width-thumbnail">Proudct</th>
                                                        <th class="width-price"> Price</th>
                                                        <th class="width-quantity">Quantity</th>
                                                        <th class="width-subtotal text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($carts as $cart)
                                                    @if ($cart)
                                                    @php
                                                        $data = [
                                                            "id" => $cart['product']['id'],
                                                            "product_name" =>
                                                            \Illuminate\Support\Str::slug($cart['product']->product_name)
                                                        ];
                                                    @endphp
                                                    <tr id="{{$cart['product']->id}}_row">
                                                        <td class="product-thumbnail">
                                                            <a href="{{ route('product_details', $data) }}">
                                                                @if ($cart['product']->related_image)
                                                                    <img src="{{ env('PHOTO_URL') . '/' . $cart['product']->related_image[0]->image }}" alt="Image" height="96">
                                                                @else
                                                                    <img src="{{ asset('contents/frontend/') }}/assets/images/empty.png" alt="Image" height="96">
                                                                @endif
                                                            </a>
                                                            <br>
                                                            <h5>
                                                                <a href="{{ route('product_details', $data) }}">
                                                                    {{ $cart['product']->product_name }}
                                                                </a>
                                                            </h5>
                                                            <a onclick="removeCart({{$cart['product']->id}})" href="javascript:void(0)" class="text-danger">
                                                                <i class="fa fa-trash-o"></i> remove
                                                            </a>
                                                        </td>
                                                        <td class="product-price">
                                                            <span class="amount">
                                                                {{ $cart['price'] }} ৳
                                                            </span>
                                                        </td>
                                                        <td class="cart-quality">
                                                            <div class="product-details-quality">
                                                                <div class="pro-qty">
                                                                    <div onclick="up_qty('dec',{{$cart['product']->id}})" class="dec qty-btn">-</div>
                                                                    <input onchange="addToCart({{$cart['product']->id}},event.target.value)" type="text" title="Quantity" value="{{ $cart['qty'] }}">
                                                                    <div onclick="up_qty('inc',{{$cart['product']->id}})" class="inc qty-btn">+</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="product-total text-end">
                                                            <span id="{{$cart['product']->id}}_cart_total">
                                                                {{ $cart['price'] * $cart['qty'] }}
                                                            </span>
                                                            <span>
                                                                ৳
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach

                                                </tbody>
                                                @else
                                                <div class="text-center">
                                                    <h2>No product found in the cart!</h2>
                                                </div>
                                                @endif
                                            </table>

                                        </div>

                                        @if (count($carts) > 0)
                                        <div class="row justify-content-end">
                                            <div class="col-md-12 col-lg-4">
                                                <div class="grand-total-wrap mt-10 mt-lg-4">
                                                    <div class="grand-total-content">
                                                        {{-- <h5 style="justify-content: space-between">
                                                            <span>
                                                                Subtotal
                                                            </span>
                                                            <span>
                                                                {{ number_format($cart_total) }}
                                                            </span>
                                                        </h5> --}}

                                                        <div class="grand-total">
                                                            <h4 class="mt-2 text-end" style="justify-content: space-between">
                                                                <span>
                                                                    Total
                                                                </span>
                                                                <span>
                                                                    <span id="cart_total">
                                                                        {{ number_format($cart_total) }}
                                                                    </span>
                                                                    <span> ৳</span>
                                                                </span>
                                                            </h4>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="cart-shiping-update-wrapper d-flex">
                                        <div class="justify-content-between cart-shiping-btn continure-btn">
                                            <a class="btn btn-link" href="/"><i class="fa fa-angle-left"></i> Back To
                                                Shop</a>
                                        </div>
                                        <div class="justify-content-between cart-shiping-btn continure-btn">
                                            @if ((int)$cart_amount > 0)
                                            <a class="btn btn-link" href="/checkout"></i> Proceed to checkout</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </section>
</main>
@endsection
