@extends('frontend.layouts.app')
@section('content')
{{-- Success is as dangerous as failure. --}}
<main class="main-content">
    @include('frontend.home.banner')
    @include('frontend.home.categories')
    @include('frontend.home.home-page-product')
    @include('frontend.home.home-page-category-product')

</main>
@endsection
