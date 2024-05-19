@foreach ($category_products as $category)

<div class="product-area section-two-space">
    <div class="custom-container">
        <h2 class="text-center mt-n2 mb-10">{{ $category->name }}</h2>
        <div class="product_row" id="home_top_products">
            @foreach ($category->products as $product)
                @include('frontend.include.product', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>

@endforeach

