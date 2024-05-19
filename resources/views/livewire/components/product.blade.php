
<div class="{{ isset($class)? $class : "col-md-3" }} mb-4" :wire:key="{{ $product->id }}">
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <style>
        .stock_alert {
            line-height: 22px;
            font-size: 17px;
            font-weight: 600;
            color: #ef4a23;
        }
    </style>
    @if (isset($product))
    @php
        $data = [
            "id" => $product->id,
            "product_name" => \Illuminate\Support\Str::slug($product->product_name)
        ];
    @endphp

    <div class="product-item product-item-border border custom-product-item">
        <div class="top">
            <a class="product-item-thumb" href="{{ route('product_details', $data) }}">
                @if (count($product->related_images) > 0 )
                    <img src="{{ $product->related_images[0]['image_link'] }}" width="228" height="228" alt="Image-Ctgcomputer">
                @endif
            </a>
            @if ($product->discounts)
                <span class="badges">-{{ $product->discounts['discount_percent'] }}%</span>
            @endif
            {{-- <div class="product-item-action">
                <button type="button" type="button" onclick="showQuickView({{ $product->id }})" data-bs-toggle="modal" data-bs-target="#action-QuickViewModal" class="product-action-btn action-btn-quick-view">
                    <i class="icon-magnifier"></i>
                </button>
            </div> --}}
            <div class="product-item-info text-center">
                <h5 class="product-item-title">
                    <a href="{{ route('product_details', $data) }}">{{ $product->product_name }}</a>
                </h5>
            </div>
        </div>
        <div class="bottom">
            @if(!is_null($product->product_brand))
                <h5 class="product-item-brand">
                    <a href="#">{{ $product->product_brand['name'] }}</a>
                </h5>
                {{-- <div class="product-item-price mb-0">{{ $product->sales_price }}<span class="price-old">{{ $product->sales_price }}</span></div> --}}
            @endif
            <div class="d-flex justify-content-center">
                <div class="product-item-price text-center">
                    @if ($product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now())
                        <div class="d-block">
                            <span class="price-old">{{ number_format($product->sales_price) }} ৳</span>
                        </div>
                        <div class="d-block">
                            <span>{{ number_format($product->sales_price-$product->discounts['discount_amount']) }} ৳</span>
                        </div>
                    @else
                        <div class="product_price_amount">
                            @if (is_numeric($product->sales_price))
                                {{ number_format($product->sales_price) }} ৳
                            @else
                                {{ $product->sales_price }}
                            @endif
                        </div>
                    @endif
                    <div class="short_description">
                        {!! $product->short_description !!}
                    </div>
                    <div class="stock_status">
                        @if($product->is_upcomming)
                            <span class="text-danger">Up comming</span>
                        @elseif ($product->is_tba)
                            <span class="text-danger">TBA</span>
                        @elseif ($product->is_pre_order)
                            <span class="text-danger">Pre Order</span>
                        @elseif (!$product->is_in_stock)
                            <span class="text-danger">Out of stock</span>
                        @else
                            <span class="text-success">In stock</span>
                        @endif
                    </div>
                </div>


                {{-- <button type="button" onclick="Livewire.emitTo('components.cart-count', 'cartAdded', {{$product->id}})" class="info-btn-cart me-4 mb-4"><i class="icon-handbag"></i></button> --}}
            </div>

            <div class="d-flex justify-content-center">
                {{-- @dump($product->toArray()) --}}
                {{-- (int) $product->stocks_sum_qty - abs((int) $product->sales_sum_qty) <= $product->low_stock --}}

                @if($product->is_upcomming)
                    <button type="button" disabled class="btn_add_to_cart mb-4">Up comming</button>
                @elseif ($product->is_tba)
                    <button type="button" disabled class="btn_add_to_cart mb-4">TBA</button>
                @elseif ($product->is_pre_order)
                    <button type="button" disabled class="btn_add_to_cart mb-4">Pre Order</button>
                @elseif (!$product->is_in_stock)
                    <button type="button" disabled class="btn_add_to_cart mb-4">Out of stock</button>
                @else
                    <button type="button"
                        onclick="addToCart({{$product->id}})"
                        class="btn_add_to_cart mb-4">
                        Add to cart
                    </button>
                @endif

            </div>
        </div>
    </div>

    @endif
</div>


