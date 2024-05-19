<div>
    <style>
        .padding{
            padding: 2rem !important;
        }
        .card {
            margin-bottom: 30px;
            border: none;
            -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e6e6f2;
        }

        h3 {
            font-size: 20px;
        }

        h5 {
            font-size: 15px;
            line-height: 26px;
            color: #3d405c;
            margin: 0px 0px 15px 0px;
            font-family: 'Circular Std Medium';
        }

        .text-dark {
            color: #3d405c !important;
        }
        @media print {
            .latest_news{
                display: none;
            }
        }
    </style>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between mb-5 print_btn">
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                    <a class="btn btn-primary" href="{{ route('frontend.orders') }}">back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding" id="print_body">

        <div class="card">
            <div class="card-header p-4 d-flex justify-content-between">
                <div class="left">
                    <a class="pt-2 d-inline-block" href="/" onclick="event.preventDefault();">Dibyo BD</a>
                    <div class="float-right">
                        <h3 class="mb-0">Invoice #{{ $order->invoice_id }}</h3>
                        Date: {{ $order->created_at }}
                    </div>
                </div>
                <div class="right text-end">
                    @php
                        $footer_logo = App\Models\Setting::select('footer_logo')->first();
                        $email_1 = App\Models\Setting::select('email_1')->first();
                        $phone_number_1 = App\Models\Setting::select('phone_number_1')->first();
                    @endphp
                    <img style="height: 80px;" src="{{ asset($footer_logo->footer_logo) }}" alt="dibyo bd">
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h5 class="mb-3">From:</h5>
                        <h3 class="text-dark mb-1">Dibyo BD</h3>
                        <div>Jatrabari, Dhaka</div>
                        <div>Email: {{ $email_1->email_1 }}</div>
                        <div>Phone: {{ $phone_number_1->phone_number_1 }}</div>
                    </div>
                    <div class="col-sm-6 text-end">
                        <h5 class="mb-3">To:</h5>
                        <h3 class="text-dark mb-1">
                            {{ $order->order_address->first_name }} {{ $order->order_address->last_name }}
                        </h3>
                        {{-- <div>478, Nai Sadak</div>
                        <div>Chandni chowk, New delhi, 110006</div> --}}
                        <div>Email: {{ $order->order_address->email }}</div>
                        <div>Phone: {{ $order->order_address->mobile_number }}</div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th class="right">Price</th>
                                <th class="center">Qty</th>
                                <th class="right text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_details as $key => $product)
                            <tr>
                                <td class="center">{{ $key+1 }}</td>
                                <td class="left strong">{{ $product->product->product_name }}</td>
                                <td class="right">{{ number_format($product->product_price) }} ৳</td>
                                <td class="center">{{ $product->qty }}</td>
                                <td class="right text-end">{{ number_format($product->product_price * $product->qty) }} ৳</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-xl-9 col-sm-8 col-md-9 col-6">
                    </div>
                    <div class="col-lg-3 col-xl-3 col-sm-4 col-md-3 col-6 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                {{-- <tr>
                                    <td class="left">
                                        <strong class="text-dark">Subtotal</strong>
                                    </td>
                                    <td class="right">{{ number_format($order->sub_total) }}</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td class="left">
                                        <strong class="text-dark">Discount</strong>
                                    </td>
                                    <td class="right">{{  }}</td>
                                </tr> --}}

                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Delivery Cost</strong>
                                    </td>
                                    <td class="right text-end">
                                        <strong class="text-dark">{{ number_format($order->delivery_cost) }} ৳</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right text-end">
                                        <strong class="text-dark">{{ number_format($order->total_price) }} ৳</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white" style="margin: 30px 0px;">
                <p class="mb-0">dibyobd.com, jatrabari, dhaka</p>
            </div>
        </div>
    </div>
</div>
