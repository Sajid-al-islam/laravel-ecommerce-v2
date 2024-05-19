<div class="list-group list-group-flush p-2">
    @foreach ($products as $item)
        @php
            $data = [
                "id" => $item->id,
                "product_name" => str_replace(' ', '-', strtolower($item->product_name))
            ];
        @endphp
        <a href="{{ route('product_details', $data) }}" class="d-flex gap-3" style="align-items: flex-start;">
            <img src="{{ env('PHOTO_URL') . '/' . $item->related_images[0]['image'] }}" width="80" height="80" style="object-fit: contain;" alt="Image-Ctgcomputer">
            <div>
                {{ $item->product_name }} <br>
                {{ $item->sales_price}} ৳
                <br>
                <br>
            </div>
        </a>
    @endforeach
    {{-- <a href="{{ route('search_product', $searchQuery) }}"
    class="mt-5 mb-2 active text-center">View more</a> --}}
</div>
