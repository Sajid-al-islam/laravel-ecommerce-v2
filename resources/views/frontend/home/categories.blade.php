{{--
<div class="product-categories-area py-5 bg-img" data-bg-img="{{ asset('contents/frontend') }}/assets/images/shop/category/bg2.jpg">
    <div class="container custom-container">
        <div class="section-title text-center">
            <h2 class="title text-black mt-n2 mb-0">Top Categories</h2>
        </div>
        <div class="swiper-button-style product-categories-items">
            <div class="d-flex gap-3 flex-wrap justify-content-center">
                @php
                    $top_categories = \App\Models\Category::where('is_top_category',1)->select(['id','name','is_top_category','category_image'])->where('status',1)->get();
                @endphp
                @foreach ($top_categories as $item)
                    <a href="/category/{{ $item->id }}/{{$item->name}}" class=" product-category-item">
                        <div class="product-category-thumb">
                            <img src="{{env('PHOTO_URL')}}/{{ $item->category_image }}" width="101" height="101" alt="Image-HasTech">
                        </div>
                        <h5 class="product-category-title">{{ $item->name }}</h5>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
--}}