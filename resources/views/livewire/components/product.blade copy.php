
<div class="{{ isset($class)? $class : 'col-md-3' }} mb-4" :wire:key="{{ $product->id }}">
    <style>
        .stock_alert {
            line-height: 22px;
            font-size: 17px;
            font-weight: 600;
            color: #ef4a23;
        }
    </style>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if (isset($product))    
    @php
        $data = [
            "id" => $product->id,
            "product_name" => \Illuminate\Support\Str::slug($product->product_name)
        ];
    @endphp
    
    <div class="product-item product-item-border custom-product-item">
        <a class="product-item-thumb" href="{{ route('product_details', $data) }}">
            @if (count($product->related_images) > 0)
                <img src="{{ $product->related_images[0]['image_link'] }}" width="228" height="228" alt="Image-Ctgcomputer">
            @endif
        </a>
        @if ($product->discounts)
            <span class="badges">-{{ $product->discounts['discount_percent'] }}%</span>
        @endif
        <div class="product-item-action">
            
            <button type="button" type="button" onclick="showQuickView({{ $product->id }})" data-bs-toggle="modal" data-bs-target="#action-QuickViewModal" class="product-action-btn action-btn-quick-view">
                <i class="icon-magnifier"></i>
            </button>
        </div>
        <div class="product-bottom">
            <div class="product-item-info text-center pb-6">
                <h5 class="product-item-title mb-2"><a href="{{ route('product_details', $data) }}">{{ $product->product_name }}</a></h5>
                {{-- <div class="product-item-price mb-0">{{ $product->sales_price }}<span class="price-old">{{ $product->sales_price }}</span></div> --}}
            </div>
            <div class="d-flex justify-content-between">
                <div class="ms-4 product-item-price mb-4">
                    @if ($product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now())
                        <div class="product-item-price">
                            {{ number_format($product->sales_price-$product->discounts['discount_amount']) }} ৳  -<span class="price-old">{{ number_format($product->sales_price) }} ৳</span>
                        </div>
                    @else
                        @if (is_numeric($product->sales_price))
                            {{ number_format($product->sales_price) }} ৳
                        @else
                            {{ $product->sales_price }}
                        @endif
                    @endif
                </div>
                @if ($product->stocks_sum_qty - $product->sales_sum_qty <= $product->low_stock)
                    <span class="me-4 mb-4 stock_alert">Out of stock</span>
                @else
                    <button type="button" onclick="Livewire.emitTo('components.cart-count', 'cartAdded', {{$product->id}})" class="info-btn-cart me-4 mb-4"><i class="icon-handbag"></i></button>
                @endif
            </div>
        </div>
    </div>
    
    @endif
</div>
    

