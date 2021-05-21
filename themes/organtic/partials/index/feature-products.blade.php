<section class=" wow bounceInUp animated mt-2">
    <div class="best-pro slider-items-products container">
        <div class="new_title">
            <img src="{{ asset('themes/organtic/assets/img/featured-products-icon.png') }}" alt="en çok satılanlar">
            <h2>{{ __('front.featured_products') }}</h2>
        </div>
        <div id="featured-products" class="product-flexslider hidden-buttons">
            <div class="slider-items slider-width-col4 products-grid">
                @foreach ( $feature_products as $product)
                    @if($product->stock > 0)
                        <div class="item">
                            <div class="item-inner">
                                <div class="item-img">
                                    <div class="item-img-info">
                                        <a href="{{ $product->slug }}"
                                           title="{{ $product->title }}"
                                           class="product-image">
                                            <img
                                                    src="{{ asset('assets/images/thumbnails/'.$product->thumbnail) }}"
                                                    alt="{{ $product->title }}">
                                        </a>
                                        @if(!empty($product->features))
                                            <div class="tag-area">
                                                @foreach($product->features as $key => $data1)
                                                    <span class="tag"
                                                          style="background-color:{{ $product->colors[$key] }}">{{ $product->features[$key] }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    @if($product->stock > 0)
                                        <div class="add_cart">
                                            <button class="button btn-cart add-to-cart" type="button"
                                                    data-href="{{ route('product.cart.add',$product->id) }}">
                                                <span>{{ __('front.add_cart') }} </span></button>
                                        </div>
                                    @endif
                                </div>
                                <div class="item-info">
                                    <div class="info-inner">
                                        <div class="item-title"><a href="{{ $product->slug }}"
                                                                   title="{{ $product->name }}">{{ $product->name }} </a>
                                        </div>
                                        <div class="item-content">
                                            <div class="rating">
                                                <div class="ratings">
                                                    <div class="rating-box">
                                                        @php
                                                            $rate = ceil($product->ratings->avg('rate'));
                                                            echo $rate;
                                                        @endphp
                                                        <div class="rating"
                                                             style="width:{{ (100 * $rate / 5) }}%"></div>
                                                    </div>
                                                    <p class="rating-links"><a
                                                                href="#">{{ __('front.review_count', ['count' => $product->ratings->count()]) }}</a>
                                                        <span class="separator">|</span> <a
                                                                href="#">{{ __('front.add_review') }}</a></p>
                                                </div>
                                            </div>
                                            <div class="item-price">
                                                <div class="price-box"><span class="regular-price"><span class="price"> {{ number_format($product->vendorSizePrice(), 2, ",", ".")}} TL </span> </span>
                                                </div>
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