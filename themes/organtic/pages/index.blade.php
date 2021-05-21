@extends('theme::layouts.app')

@section('theme::styles')

    <style>
        .brand-slider .owl-item .item .logo-item > a > img {
            width: 200px;
        }
    </style>
@endsection

@section('theme::content')

    @include('theme::partials.index.slider')

    @include('theme::partials.index.featured-categories')

    {{--@include('theme::partials.index.campaigns')--}}

    @include('theme::partials.index.feature-products')

    <section id="extraData">
        <div class="text-center">
            <img src="{{asset('assets/images/'.$gs->loader)}}">
        </div>
    </section>

    {{--@include('theme::partials.index.posts')--}}

@endsection

@section('theme::scripts')
    <script>

        $(window).on('load',function() {

            setTimeout(function(){

                $('#extraData').load('{{route('front.extraIndex')}}',function() {
                    loadCarousels()
                });
            }, 500);
        });

        function loadCarousels() {
            $("#best-seller .slider-items").owlCarousel({
                items: 4,
                itemsDesktop: [1024, 4],
                itemsDesktopSmall: [900, 3],
                itemsTablet: [600, 2],
                itemsMobile: [320, 1],
                navigation: !0,
                navigationText: ['<a class="flex-prev"></a>', '<a class="flex-next"></a>'],
                slideSpeed: 500,
                pagination: !1
            })
            $("#brand-slider .slider-items").owlCarousel({
                autoplay : true,
                items : 5, //10 items above 1000px browser width
                itemsDesktop : [1024,5], //5 items between 1024px and 901px
                itemsDesktopSmall : [900,4], // 3 items betweem 900px and 601px
                itemsTablet: [600,2], //2 items between 600 and 0;
                itemsMobile : [200,1],
                navigation : false,
                navigationText : ["<a class=\"flex-prev\"></a>","<a class=\"flex-next\"></a>"],
                slideSpeed : 500,
                pagination :true
            })
        }


    </script>
@endsection