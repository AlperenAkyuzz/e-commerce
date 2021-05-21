@extends('theme::layouts.app')

@section('theme::styles')

@endsection

@section('theme::content')

    <section class=" wow bounceInUp animated">
        <div class="best-pro slider-items-products container">
            <div class="new_title" style="margin-top: 30px;">

                <h2>{{ $vendor->shop_name }}</h2>
            </div>
            <div id="best-seller" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 products-grid">
                    @foreach ( $vprods as $product)
                        @if($product->status === 1)
                            <div class="item">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info"><a href="{{ url($product->slug) }}" title="{{ $product->title }}" class="product-image"><img src="{{ asset('assets/images/thumbnails/'.$product->thumbnail) }}" alt="{{ $product->title }}"></a>
                                            <div class="new-label new-top-left">Hot</div>
                                            <div class="sale-label sale-top-left">-15%</div>
                                        </div>
                                        @if($product->stock > 0)
                                            <div class="add_cart">
                                                <button class="button btn-cart" type="button"><span>{{ __('front.add_cart') }} </span></button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"><a href="{{ url($product->slug) }}" title="{{ $product->title }}">{{ $product->title }} </a> </div>
                                            <div class="item-content">
                                                <div class="rating">
                                                    <div class="ratings">
                                                        <div class="rating-box">
                                                            @php
                                                                $rate = ceil($product->ratings->avg('rate'));
                                                                echo $rate;
                                                            @endphp
                                                            <div class="rating" style="width:{{ (100 * $rate / 5) }}%"></div>
                                                        </div>
                                                        <p class="rating-links"><a href="#">{{ __('front.review_count', ['count' => $product->ratings->count()]) }}</a> <span class="separator">|</span> <a href="#">{{ __('front.add_review') }}</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"><span class="regular-price" ><span class="price"> {{ $product->price }} TL </span> </span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </section>

@endsection

@section('theme::scripts')

@endsection