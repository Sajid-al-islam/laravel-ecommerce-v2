@extends('frontend.layouts.app',[
    "meta" => [
        "title" => "terms and conditions",
    ]
])
@section('content')
<main class="main-content">
    <section>
        <div class="container">
            <ul class="breadcrumb pt-4">
                <li>
                    <a href="/"><i class="fa fa-home" title="Home"></i></a>
                </li>
                <li>
                    <a href="#">
                        <span>terms and conditions</span>
                    </a>
                </li>
            </ul>
    </section>

    <section style="background: #f2f4f8;">
        <br>
        <br>
        <div class="container ">
            <div class="card">
                <div class="card-body">
                    <div class="about_website_section">
                        {{-- <h1 class="heading">Our Introduction</h1> --}}
                        {!! \App\Models\Setting::select('terms_condition')->first()->terms_condition !!}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </section>
</main>
@endsection
