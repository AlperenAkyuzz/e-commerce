@extends('theme::layouts.app')

@section('theme::title', $catalogName ?? __('front.products'))

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