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
@endsection
