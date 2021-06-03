@extends('theme::layouts.app')

@section('theme::title', $product->name)

@section('theme::styles')
    <style>
        .owl-theme .owl-controls {
            display: block !important;
        }
        .color-red {
            color: #ff000f;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type="radio"] { display: none; } input[type="radio"] + label { font-weight: 400; font-size: 14px; } input[type="radio"] + label span { display: inline-block; width: 18px; height: 18px; margin: -2px 10px 0 0; vertical-align: middle; cursor: pointer; -moz-border-radius: 50%; border-radius: 50%; border: 3px solid #ffffff; } input[type="radio"] + label span { background-color: #e0e0e0; } input[type="radio"]:checked + label { color: #333; font-weight: 700; } input[type="radio"]:checked + label span { background-color: #046a38; border: 2px solid #ffffff; box-shadow: 2px 2px 2px rgba(0,0,0,.1); }  input[type="radio"] + label span, input[type="radio"]:checked + label span { -webkit-transition: background-color 0.24s linear; -o-transition: background-color 0.24s linear; -moz-transition: background-color 0.24s linear; transition: background-color 0.24s linear; }


    </style>

@endsection

@section('theme::content')

    @include('theme::partials.product.detail.breadcrumb')

    <div class="main-container col1-layout wow bounceInUp animated product-container" data-pid="{{ $product->id }}">
        <div class="main">
          <div class="col-main">
            <!-- Endif Next Previous Product -->
            <div class="product-view wow bounceInUp animated" itemscope="" itemtype="http://schema.org/Product"
              itemid="#product_base" data-uuid="{{ $product->uuid }}">
              <div id="messages_product_view"></div>
              @include('theme::partials.product.detail.summary')
              @include('theme::partials.product.detail.tabs')
              @include('theme::partials.product.detail.releated')
              @include('theme::partials.product.detail.meta')
            </div>
          </div>
        </div>
    </div>
    

@endsection

@section('theme::scripts')

    <script>
        var $root = $('html, body');
        $('.rating-links a').click(function(event){
            event.preventDefault();
            var href = $(this).data('href');
            $root.animate({
                scrollTop: $(href).offset().top - 300
            }, 500);
            $('#review_tab_link').addClass('active');
            $('#description_tab_link').removeClass('active');
            $('#productTabContent #product_tabs_description').removeClass('in active');
            $('#productTabContent #reviews_tabs').addClass('in active');
            return false;
        });
    </script>

    <!--<script src="{{ asset('themes/organtic/assets/js/cloud-zoom.js') }}"></script>-->
    <!--<script src="{{ asset('themes/organtic/assets/js/product/events.js?v=0.0.11') }}"></script>-->
@endsection