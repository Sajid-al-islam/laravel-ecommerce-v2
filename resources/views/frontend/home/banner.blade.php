<div>
    {{-- The whole world belongs to you. --}}
    <div class="hero-five-slider-area bg_offwhite">
        <div class="container custom-container">
            <style>
                @media (min-width: 992px){
                    .custom_banner{
                        /*height: 550px;*/
                        overflow: hidden;
                    }
                }
                
            </style>
            <div class="custom_banner">
                <div class="owl-carousel owl-theme">
                    @foreach(\App\Models\WebsiteBanner::where('show',1)->orderBy('id','DESC')->get() as $item)
                    <div>
                        <img src="{{env('PHOTO_URL')}}/{{$item->image}}" alt="Image">
                    </div>
                    @endforeach
                </div>
            </div>
            
            
            {{-- <div class="banner_body">
                <div class="one">
                    <div class="owl-carousel owl-theme">
                        @foreach(\App\Models\WebsiteBanner::where('show',1)->orderBy('id','DESC')->get() as $item)
                        <div>
                            <img src="{{env('PHOTO_URL')}}/{{$item->image}}" alt="Image">
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="two">
                    <img src="/{{$setting->side_banner_left_top}}" class="img-fluid" alt="">
                </div>
                <div class="three">
                    <img src="/{{$setting->side_banner_right_top}}" class="img-fluid" alt="">
                </div>
                <div class="four">
                    <img src="/{{$setting->side_banner_left_bottom}}" class="img-fluid" alt="">
                </div>
                <div class="five">
                    <img src="/{{$setting->side_banner_right_bottom}}" class="img-fluid" alt="">
                </div>
            </div> --}}
        </div>
    </div>
</div>
