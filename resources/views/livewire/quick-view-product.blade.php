<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="product-quick-view-content">
        <button type="button" class="btn-close" id="close_quick_view_modal" data-bs-dismiss="modal"><span>×</span></button>
        <div class="row row-gutter-0">
            <div class="col-lg-6">
                <div class="single-product-slider">
                    <div class="single-product-thumb">
                        <div class="swiper single-product-quick-view-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="thumb-item">
                                        <img src="{{env('PHOTO_URL')}}/{{ $product->related_images[0]['image'] }}" alt="Image" width="640" height="710">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-detail-content mt-6 mt-lg-0">
                    <h2 class="product-detail-title mt-n1 me-10">{{ $product->product_name; }}</h2>
                    @if ($product->discounts && $product->discounts['discount_last_date'] > Carbon\Carbon::now())
                        <div class="product-detail-price">
                            {{ number_format($product->sales_price-$product->discounts['discount_amount']) }} ৳ - <span class="price-old">{{ number_format($product->sales_price) }} ৳</span>
                        </div>
                    @else
                        @if (is_numeric($product->sales_price))
                            <div class="product-detail-price">{{ number_format($product->sales_price) }} ৳</div>
                        @else
                            <div class="product-detail-price">{{ $product->sales_price }}</div>
                        @endif
                    @endif
                    <div class="mb-3">
                        <button class="product-detail-cart-btn" onclick="addToCart({{ $product->id }})" type="button">Add to cart</button>
                    </div>

                    <ul class="product-detail-meta pt-6">
                        <li><span>Categories:</span>
                        @foreach ($product->related_categories as $item)
                            {{ $item->name }},
                        @endforeach</li>
                    </ul>

                    <div class="product-detail-desc">
                        {!! $product->description  !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
