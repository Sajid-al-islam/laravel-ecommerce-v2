<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="h5">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th scope="row">
                    <div class="d-flex align-items-center">
                        <img src="{{ $product->related_images[0]['image_link'] }}"
                            class="img-fluid rounded-3"
                            style="width: 120px;" alt="Book">
                        <div class="flex-column ms-4">
                            <p class="mb-2">{{ $product->product_name }}</p>
                        </div>
                    </div>
                </th>
                <td class="align-middle">
                    X 1
                </td>
                <td class="align-middle">
                    <p class="mb-0" style="font-weight: 500;">{{ $product->sales_price }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<li class="list-group-item d-flex justify-content-between">
    <span>Subtotal</span>
    <strong>{{ $product->sales_price }} ৳</strong>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span>Shipping</span>
    <strong id="shipping_cost">{{ $delivery_cost > 0 ? $delivery_cost . ' ৳' : 'ফ্রী ডেলিভারি' }}</strong>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span>Discount</span>
    <strong id="discount_landing">0 ৳</strong>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span>Total</span>
    <strong id="total_amount">{{ $product->sales_price + $delivery_cost }} ৳</strong>
</li>
