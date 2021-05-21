<div class="section-orders">

    <div class="row">
        <div class="col-main col-12 product-list">
            <div class="pro-coloumn">
                <article>
                    <div class="category-products">
                        <ol class="products-list" id="products-list">
                            @foreach($products as $product)
                                <li class="item order-item">
                                    <div class="product-image d-flex">
                                        <img class="small-image"
                                             src="{{ asset('assets/images/products/'.$product['item']['photo']) }}"
                                             alt="HTC Rhyme Sense">

                                    </div>
                                    <div class="product-shop">
                                        <h2 class="product-name"><a href="{{ url($product['item']['slug']) }}"
                                                                    target="_blank"
                                                                    title="{{ $product['item']['name'] }}">{{ $product['item']['name'] }}</a>
                                        </h2>
                                        <div class="unit-price">
                                            <h5 class="label">{{ __('front.price') }}
                                                : <span>{{ App\Models\Product::convertPrice($product['item_price']) }}</span></h5>
                                        </div>
                                        @if(!empty($product['size']))
                                            <div class="unit-price">
                                                <h5 class="label">{{ __('front.price') }} : </h5>
                                                <p>{{ str_replace('-',' ',$product['size']) }}</p>
                                            </div>
                                        @endif
                                        @if(!empty($product['color']))
                                            <div class="unit-price">
                                                <h5 class="label">{{ __('front.color') }} : </h5>
                                                <span id="color-bar"
                                                      style="border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
                                            </div>
                                        @endif
                                        @if(!empty($product['keys']))

                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                <div class="quantity">
                                                    <h5 class="label">{{ ucwords(str_replace('_', ' ', $key))  }}
                                                        : <span>{{ $value }}</span></h5>
                                                </div>
                                            @endforeach

                                        @endif
                                        <div class="quantity">
                                            <h5 class="label">{{ __('front.quantity') }} : <span>{{ $product['qty'] }}</span>  </h5>
                                            <span class="qttotal"> </span>
                                        </div>
                                        <div class="total-price">
                                            <h5 class="label">{{ __('front.total') }}
                                                : <span>{{ App\Models\Product::convertPrice($product['price']) }}</span></h5>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>