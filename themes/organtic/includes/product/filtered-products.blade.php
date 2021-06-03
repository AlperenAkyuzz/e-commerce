<div class="col-main col-sm-9 col-sm-push-3 product-grid">
@if (count($prods) > 0)
    <div class="pro-coloumn">
        <article>
            <div class="category-products">
                <ul class="products-grid">
                    @foreach ($prods as $key => $product)
                        @if($product->stock > 0)
                        <li class="item col-lg-4 col-md-3 col-sm-4 col-xs-6">
                            <div class="item-inner">
                                <div class="item-img">
                                    <div class="item-img-info">
                                        <a href="{{ url( $product->slug) }}" title="{{ $product->showName() }} "
                                           class="product-image">
                                            <img src="{{ asset('assets/images/thumbnails/'.$product->thumbnail) }}"
                                                 alt="{{ $product->showName() }}" width="280" height="280">
                                        </a>
                                        @if(!empty($product->features))
                                            <div class="tag-area">
                                                @foreach($product->features as $key => $data1)
                                                    <span class="tag" style="background-color:{{ $product->colors[$key] }}">{{ $product->features[$key] }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="add_cart">
                                        <button class="button btn-cart add-to-cart" type="button" data-href="{{ route('product.cart.add',$product->id) }}"><span>{{ __('front.add_cart') }} </span></button>
                                    </div>
                                </div>
                                <div class="item-info">
                                    <div class="info-inner">
                                        <div class="item-title"><a href="{{ url( $product->slug) }}"
                                                                   title="{{ $product->showName() }}">{{ $product->showName() }} </a> </div>
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
                                                </div>
                                            </div>
                                            <div class="item-price">
                                                <div class="price-box">
                                                    @if($product->previous_price > $product->price )
                                                        <del>{{ $product->showPreviousPrice() }}</del>
                                                    @endif
                                                    <span class="regular-price">
                                                        <span class="price">{{ number_format($product->price, 2, ",", ".")}} TL </span>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </article>
    </div>
@else
    @if(isset($ajax_check) && $ajax_check == 1)
        <h4 style="margin-top:30px;">Seçtiğiniz kriterlere göre uygun ürün bulunamadı.</h4>
    @else
        <h4 style="margin-top:30px;">Bu kategoride ürün yok</h4>
    @endif
@endif
</div>
