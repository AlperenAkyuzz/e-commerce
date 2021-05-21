@extends('theme::layouts.app')

@section('theme::title', $catalogName)

@section('theme::styles')

    <style>
        .input-group {
            display: flex;
        }

        .input-group-append {
            margin-left: 5px;
        }

        .input-group > .input-group-append > .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            padding: 6px 12px;
            background: #058044;
            color: #FFFFFF;
        }

        .input-group > .input-group-append > .btn:hover {
            background: #036435;
        }

        .price-range-block {
            margin-bottom: 10px;
        }

        /* Disable Number Arrow */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .range-contain-center {
            width: 16px;
            text-align: center;
            line-height: 32px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .pagination > li:first-child > a, .pagination > li:first-child > span {
            border-radius: 0px;
        }

        #ajaxContent .col-main {
            margin-top: 0px;
        }

        .categori-item-area .col-main .tool-coloumn {
            padding-bottom: 0px;
        }
    </style>

@endsection

@section('theme::content')

    @include('theme::partials.category.breadcrumb')

    <div id="CssLoader">
        <div class='spinftw'></div>
    </div>

    <section class="main-container col2-left-layout bounceInUp animated">
        <div class="container">
            <div class="row categori-item-area">
                @include('theme::partials.category.toolbar')
                <div id="ajaxContent">

                    @include('theme::includes.product.filtered-products')
                </div>
                {{-- Filter --}}
            @include('theme::partials.category.filter')
            {{--col-right sidebar--}}
            </div>
            {{--row--}}
        </div>
        {{--container--}}
    </section>
@endsection

@section('theme::scripts')

    <script>
        var routeURI = '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}';
    </script>
@endsection