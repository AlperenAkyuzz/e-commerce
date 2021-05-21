@if(Session::has('cart'))
    <div class="fl-mini-cart-content" style="display: none;">
        <div class="block-subtitle">
            <div class="top-subtotal">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }} ürün, <span
                        class="price main-total">₺{{ Session::has('cart') ? number_format(Session::get('cart')->totalPrice, 1, ",", ".") : '0.00' }}</span>
            </div>
            {{-- top-subtotal --}}
            {{-- pull-right --}}
        </div>
        <ul class="mini-products-list" id="cart-sidebar">
            @foreach(Session::get('cart')->items as $product)
                <li class="item cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
                    <div class="item-inner">
                        <a class="product-image"
                           title="{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}"
                           href="{{ url($product['item']['slug']) }}">
                            <img alt="{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}"
                                 src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}">
                        </a>
                        <div class="product-details">
                            <div class="access">
                                <div class="btn-remove1 cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" title="Remove Product">
                                    <i class="fa fa-close"></i>
                                </div>
                            </div>
                            {{-- access --}}
                            {{-- App\Models\Product::convertPrice($product['item_price']) --}}
                            <strong>{{$product['qty']}}</strong> x <span class="price">₺{{ number_format($product['item_price'], 1, ",", ".") }}</span>
                            <p class="product-name"><a href="{{ url($product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}</a></p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="actions">
            <a class="btn-checkout" title="Checkout" type="button"
               href="{{ route('front.checkout') }}">
                <span>{{ __('front.proceed_to_checkout') }}</span>
            </a>
        </div>
        {{-- actions --}}
    </div>
    {{-- fl-mini-cart-content --}}
@endif