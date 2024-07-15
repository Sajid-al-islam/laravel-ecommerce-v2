@extends('frontend.layouts.layout_blank', [
    'meta' => [
        'title' => 'Premium Fruit shop - Thank you',
    ],
])
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center mt-5  ">
                <img src="{{ asset('contents/frontend/assets/images/thanks.jpg') }}" class="img-fluid" alt="">
            </div>
            <h2 class="my-4 text-center">
                আপনার অর্ডারটি কনফার্ম হয়েছে! অতি শীগ্রই আমাদের একজন প্রতিনিধি আপনার সাথে যোগাযোগ করবে।
            </h2>
        </div>
    </div>
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1062700004978868');
        fbq('track', 'PageView');
        var total_amount = {!! $total_amount !!};
        var product_skus = @json($product_ids);
        console.log(product_skus, total_amount);
        fbq('track', 'Purchase',{
            value: total_amount,
            currency: 'BDT',
            content_ids: product_skus,
            content_type: 'product'
        });
        console.log('after api call',product_skus, total_amount);
    </script>
@endsection
