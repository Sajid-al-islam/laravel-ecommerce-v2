@extends('frontend.layouts.app')
@section('content')
    <style>
        .product_list {
            display: grid;
            gap: 15px;
            grid-template-columns: 190px 1fr
        }
        
        .product_list .close_filter {
            color: red;
            display: none;
            font-size: 25px;
            left: 0;
            position: sticky;
            text-align: right;
            top: 0
        }
        
        .product_list .close_filter i {
            cursor: pointer
        }
        
        .product_list .product_filter_toggler {
            display: none
        }
        
        @media (max-width: 1199.9px) {
            .product_list,.product_list .close_filter,.product_list .product_filter_toggler {
                display:block
            }
        }
        
        .category_product_row {
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(auto-fit,242px)
        }
        
        @media (min-width: 992px) and (max-width:1199.9px) {
            .category_product_row {
                grid-template-columns:repeat(auto-fit,222px)
            }
        }
        
        @media (min-width: 0px) and (max-width:1399.9px) {
            .category_product_row {
                grid-template-columns:repeat(auto-fit,minmax(222px,1fr))
            }
        
            .category_product_row .product-item {
                max-width: 340px
            }
        }
        
        .category_products_heading_wrap {
            margin-bottom: 15px
        }
        
        .category_products_heading {
            font-size: 16px;
            font-weight: 700;
            line-height: 30px;
            line-height: 51px;
            padding: 0 10px
        }
        
        #category_products_paginations nav {
            background-color: unset;
            -webkit-box-shadow: unset;
            box-shadow: unset;
            height: unset;
            max-width: unset;
            overflow: hidden;
            position: unset;
            width: unset
        }
        
        #category_products_paginations nav .pagination {
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 10px
        }
        
        @media (max-width: 1199.9px) {
            .filter_card_list {
                background:#10355a;
                -webkit-box-shadow: 0 0 10px rgba(0,0,0,.251);
                box-shadow: 0 0 10px rgba(0,0,0,.251);
                display: none;
                height: 100vh;
                overflow-x: hidden;
                overflow-y: scroll;
                padding: 8px;
                position: fixed;
                right: 0;
                top: 0;
                width: 300px;
                z-index: 10000
            }
        
            .filter_card_list.active {
                display: block
            }
        }
        
        .filter_card_list .filter_card .filter_list {
            max-height: 300px;
            overflow-y: auto
        }
        
        .filter_card_list .filter_card .filter_header {
            position: relative
        }
        
        .filter_card_list .filter_card .filter_toggler {
            cursor: pointer;
            height: 40px;
            line-height: 40px;
            position: absolute;
            right: 0;
            text-align: center;
            top: 0;
            width: 40px
        }
        @media(max-width: 575.9px){
            .filter_card{
                max-width: 100%;   
                
            }
            .product_row.category_product_row {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
    @if($category)
        <section>
            <div class="container">
                <ul class="breadcrumb pt-4">
                    <li>
                        <a href="/"><i class="fa fa-home" title="Home"></i></a>
                    </li>
                    <li>
                        <a href="#">
                            <span>category</span>
                        </a>
                    </li>
                    @if($category->parent)
                    <li>
                        <a href="/category/{{$category->parent->id}}/{{$category->parent->name}}">
                            <span>{{$category->parent->name}}</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="/category/{{$category->id}}/{{$category->name}}" onclick="event.preventDefault();">
                            <span>{{$category->name}}</span>
                        </a>
                    </li>
                </ul>
                <div class="child_list">
                    @foreach($category->child as $child)
                        @php
                            $data = [
                                "id" => $child->id,
                                "category_name" => str_replace(' ', '-', strtolower($child->name))
                            ];
                        @endphp
                        <a href="{{ route('category_product', $data) }}">{{$child->name}}</a>
                    @endforeach
                </div>
            </div>
        </section>
        <section style="background: #f2f4f8;">
            <link rel="stylesheet" href="/contents/frontend/assets/css/plugins/range_slider.css" />
            <script src="/contents/frontend/assets/js/plugins/range_slider.js"></script>
            <script src="/contents/frontend/assets/js/plugins/debounce.js"></script>
            <div class="container py-3">
                <div class="product_list">
                    <div class="filter_card_list" id="filter_card_list">
                        <div class="close_filter" onclick="filter_card_list.classList.toggle('active');">
                            <i class="fa fa-close"></i>
                        </div>
                        @if ($max_product_price)
                            <div class="mb-3 bg-white filter_card">
                                <div class="card-header bg-white">
                                    <b>
                                        Price Range
                                    </b>
                                </div>
                                <div class="p-2">
                                    <div id="anchor2"></div>
                                    <div class="d-flex justify-content-between gap-4">
                                        <input type="number" id="min_input" value="{{request()->min ?? $min_product_price}}" onkeyup="set_min_max(0,event.target.value)" class="form-control p-1 rounded-0" />
                                        <input type="number" id="max_input" value="{{request()->max ?? $max_product_price}}" onkeyup="set_min_max(1,event.target.value)" class="form-control p-1 rounded-0" />
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3 bg-white filter_card">
                            <div class="card-header bg-white d-flex justify-content-between">
                                <b>
                                    Availability
                                </b>
                                <b>
                                    <i class="fa fa-angle-down" onclick="stock_list.classList.toggle('d-none')"></i>
                                </b>
                            </div>
                            <div class="p-2 d-block" id="stock_list">
                                <ul>
                                    <li>
                                        <label for="is_in_stock">
                                            <input type="radio" {{request()->availability=='is_in_stock'?'checked':''}} onchange="change_availablity()" class="form-check-input me-2" value="1" id="is_in_stock" name="availability">
                                            In Stock Avaiable
                                        </label>
                                    </li>
                                    <li>
                                        <label for="is_pre_order">
                                            <input type="radio" {{request()->availability=='is_pre_order'?'checked':''}} onchange="change_availablity()" class="form-check-input me-2" value="1" id="is_pre_order" name="availability">
                                            Pre Order
                                        </label>
                                    </li>
                                    <li>
                                        <label for="is_upcomming">
                                            <input type="radio" {{request()->availability=='is_upcomming'?'checked':''}} onchange="change_availablity()" class="form-check-input me-2" value="1" id="is_upcomming" name="availability">
                                            Upcomming
                                        </label>
                                    </li>
                                    <li>
                                        <label for="is_tba">
                                            <input type="radio" {{request()->availability=='is_tba'?'checked':''}} onchange="change_availablity()" class="form-check-input me-2" value="1" id="is_tba" name="availability">
                                            To Be Announce
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3 bg-white filter_card">
                            <div class="card-header bg-white d-flex justify-content-between">
                                <b>
                                    Brands
                                </b>
                                <b>
                                    <i class="fa fa-angle-down" onclick="brand_list.classList.toggle('d-none')"></i>
                                </b>
                            </div>
                            <div class="p-2 d-block" id="brand_list">

                            </div>
                        </div>
                    </div>
                    <div>
                        <section class="bg-white d-flex flex-wrap gap-2 category_products_heading_wrap">
                            <button onclick="filter_card_list.classList.toggle('active');" class="btn product_filter_toggler rounded-none btn-sm btn-primary px-3">
                                <i class="fa fa-align-left me-2"></i>
                                Filter
                            </button>
                            <h1 class="category_products_heading">
                                
                                Component
                                
                            </h1>
                        </section>
                        <div class="product_row category_product_row" id="category_product_list">

                        </div>
                        <div class="col-12 my-4" id="category_products_paginations">

                        </div>
                    </div>
                            
                </div>
                
                <div class="">
                    <script>
                        var range_value = [];
                        var brands = '';
                        var availability = '';

                        function set_min_max(index=0,value=0){
                            range_value[index] = value;
                            debounce(load_data, 1000)();
                        }

                        function change_availablity(){
                            availability = event.target.id;
                            debounce(load_data, 300)();
                        }

                        function change_brand(){
                            brands = [...document.querySelectorAll('input[name="selected_brands"]')];
                            brands = brands.filter(i=>i.checked).map(i=>i.value);
                            debounce(load_data, 300)();
                        }

                        function load_data(event){
                            var [min, max] = range_value;
                            var url = new URL(location.href);

                            if(min){
                                min_input.value = min;
                                url.searchParams.set('min',min);
                            }

                            if(max){
                                max_input.value = max;
                                url.searchParams.set('max',max);
                            }

                            url.searchParams.forEach((i,k)=>k.includes('brands') && url.searchParams.delete(k))
                            if(brands.length){
                                brands.forEach((i,index)=>url.searchParams.set(`brands[${index}]`,i));
                            }

                            if(availability){
                                url.searchParams.set('availability',availability);
                            }

                            url.searchParams.set('page',1);
                            window.history.pushState({path:url.href},'',url.href);
                            load_category_product();
                            // Turbolinks.visit(url.href);
                        }

                        setTimeout(() => {
                            $('#anchor2').html('');
                            if($('#anchor2')[0]){
                                $('#anchor2').rangeSlider({
                                    settings: false,
                                    skin: 'red',
                                    type: 'interval',
                                    scale: false,
                                },{
                                    min: {{(int) $min_product_price ?? 50}},
                                    max: {{(int) $max_product_price ?? 40000}},
                                    step: 1,
                                    values: [{{request()->min ?? (int)$min_product_price}}, {{request()->max ?? (int) $max_product_price}}]
                                });
                                $('#anchor2').rangeSlider('onChange',(event)=>{
                                    var [min, max] = event.detail.values;
                                    min_input.value = min;
                                    max_input.value = max;
                                })
                                $('#anchor2').rangeSlider('onChange',debounce((event)=>{
                                    range_value = event.detail.values;
                                    load_data();
                                },1000))
                            }
                        }, 1000);
                    </script>
                </div>
            </div>
        </section>
    @else
        <div class="text-center">
            There no product according to this category
        </div>
    @endif
@endsection
