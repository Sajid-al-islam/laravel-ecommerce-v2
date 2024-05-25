<div class="mb-4">
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
            try {
                //code...
                $data = [
                    'id' => $product->id,
                    'product_name' => \Illuminate\Support\Str::slug($product->product_name),
                ];
            } catch (\Throwable $th) {
                dd($product);
            }
            $has_variant = count($product->product_variant()->get());
            if($has_variant) {
                $lowest_price = $product->product_variant()->orderBy('variant_price', 'asc')->first();
                $highest_price = $product->product_variant()->orderBy('variant_price', 'desc')->first();
            }
        @endphp

        <div class="product-item product-item-border border custom-product-item">
            <div class="top">
                <a class="product-item-thumb" href="{{ route('product_details', $data) }}">
                    @if (count($product->related_images) > 0)
                        <img src="{{ $product->related_images[0]['image_link'] }}" width="228" height="228"
                            alt="Image-Ctgcomputer">
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
                <div class="d-flex justify-content-center">
                    <div class="product-item-price text-center">
                        {{-- <div class="short_description">
                            {!! $product->short_description !!}
                        </div> --}}

                        @if (!is_null($product->product_brand))
                            <h5 class="product-item-brand">
                                <a href="#">{{ $product->product_brand['name'] }}</a>
                            </h5>
                            {{-- <div class="product-item-price mb-0">{{ $product->sales_price }}<span class="price-old">{{ $product->sales_price }}</span></div> --}}
                        @endif

                        @if ($product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now())
                            @if ($has_variant)
                                <span id="variant_price_set">{{ number_format($lowest_price->variant_price) }}৳ - {{ number_format($highest_price->variant_price) }}৳</span>
                            @else
                                <div class="d-block">
                                    <span class="price-old">{{ number_format($product->sales_price) }} ৳</span>
                                </div>
                                <div class="d-block">
                                    <span>{{ number_format($product->sales_price - $product->discounts['discount_amount']) }}
                                        ৳</span>
                                </div>
                            @endif
                        @else
                            <div class="product_price_amount">
                                @if (is_numeric($product->sales_price))
                                    @if ($has_variant)
                                        <span id="variant_price_set">{{ number_format($lowest_price->variant_price) }}৳ - {{ number_format($highest_price->variant_price) }}৳</span>
                                    @else
                                        {{ number_format($product->sales_price) }} ৳
                                    @endif
                                @else
                                    {{ $product->sales_price }}
                                @endif
                            </div>
                        @endif

                        {{-- <div class="stock_status">
                        @if ($product->is_upcomming)
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
                    </div> --}}
                    </div>

                </div>

                <div class="d-flex justify-content-center">

                    <button type="button" onclick="location.href = `{{ route('product_details', $data) }}`"
                        class="btn_add_to_cart mb-4">
                        Buy Now
                    </button>

                </div>
            </div>
        </div>

    @endif
</div>
