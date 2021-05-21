@extends('theme::layouts.app')

@section('theme::title', __('front.cart'))

@section('theme::styles')


@endsection

@section('theme::content')

    <div class="page-heading" style="background-image: url({{ asset('themes/organtic/assets/img/category-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2>{{ __('front.cart') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container col1-layout wow bounceInUp animated">

        <div id="CssLoader">
            <div class='spinftw'></div>
        </div>

        <div class="main">
            <div class="cart wow bounceInUp animated">

                <div class="container">
                    @include('includes.form-success')
                </div>


                <div class="table-responsive shopping-cart-tbl  container">
                    <form action="#" method="post">
                        <input name="form_key" type="hidden" value="EPYwQxF6xoWcjLUr">
                        <fieldset>
                            <table id="shopping-cart-table overflow-x:auto;"
                                   class="data-table cart-table table-striped">
                                <colgroup>
                                    <col width="1">
                                    <col>
                                    <col width="1">
                                    <col width="1">
                                    <col width="1">
                                    <col width="1">
                                    <col width="1">

                                </colgroup>
                                <thead>
                                <tr class="first last">
                                    <th rowspan="1">&nbsp;</th>
                                    <th rowspan="1"><span class="nobr">{{ __('front.product_name') }}</span></th>
                                    <th rowspan="1"><span class="nobr">{{ __('front.attributes') }}</span></th>
                                    <th class="a-center" colspan="1"><span
                                                class="nobr">{{ __('front.unit_price') }}</span></th>
                                    <th rowspan="1" class="a-center">{{ __('front.quantity') }}</th>
                                    <th class="a-center" colspan="1">{{ __('front.subtotal') }}</th>
                                    <th rowspan="1" class="a-center">&nbsp;</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr class="first last">
                                    <td colspan="50" class="a-right last">
                                        <button type="button" onclick="location.href='{{ url('/') }}'"
                                                title="{{ __('front.continue_shopping') }}"
                                                class="button btn-continue"
                                                onClick="">
                                            <span><span>{{ __('front.continue_shopping') }}</span></span></button>
                                        <button type="button" onclick="window.location.reload();"
                                                name="update_cart_action" value="update_qty"
                                                title="{{ __('front.update_cart') }}" class="button btn-update">
                                            <span><span>{{ __('front.update_cart') }}</span></span></button>
                                        {{--<button type="button" name="update_cart_action" value="empty_cart"
                                                title="{{ __('front.clear_cart') }}" class="button btn-empty"
                                                id="empty_cart_button">
                                            <span><span>{{ __('front.clear_cart') }}</span></span></button> --}}

                                    </td>
                                </tr>
                                </tfoot>
                                <tbody>


                                @if(Session::has('cart'))
                                    @foreach($products as $product)
                                        <tr class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }} @if ($loop->first) first last odd @elseif($loop->last) last @else odd @endif">
                                            <td class="image hidden-table">
                                                <a href="{{ url($product['item']['slug']) }}"
                                                   title="{{mb_strlen($product['item']['name'],'utf-8') > 35 ? mb_substr($product['item']['name'],0,35,'utf-8').'...' : $product['item']['name']}}"
                                                   class="product-image">
                                                    <img src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}"
                                                         width="75"
                                                         alt="{{mb_strlen($product['item']['name'],'utf-8') > 35 ? mb_substr($product['item']['name'],0,35,'utf-8').'...' : $product['item']['name']}}">
                                                </a>
                                            </td>
                                            <td>
                                                <h2 class="product-name">
                                                    <a href="{{ url($product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 35 ? mb_substr($product['item']['name'],0,35,'utf-8').'...' : $product['item']['name']}}</a>
                                                </h2>
                                            </td>

                                            <td>
                                                @if(!empty($product['size']))
                                                    <b>{{ $langg->lang312 }}</b>
                                                    : {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}}
                                                    <br>
                                                @endif
                                                @if(!empty($product['color']))
                                                    <div class="d-flex mt-2">
                                                        <b>{{ $langg->lang313 }}</b>:
                                                        <span id="color-bar"
                                                              style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};">
                                                        </span>
                                                    </div>
                                                @endif

                                                @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }}
                                                            : </b> {{ $value }} <br>
                                                    @endforeach

                                                @endif
                                            </td>

                                            <td class="a-right hidden-table">
                                            <span class="cart-price">
                                                <span class="price">{{ number_format(round($product['item_price'], 1), 2, ",", ".") }}</span>
                                            </span>
                                            </td>
                                            <td class="a-center movewishlist">
                                                <input type="hidden" class="prodid" value="{{$product['item']['id']}}">
                                                <input type="hidden" class="itemid"
                                                       value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                                                <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">
                                                <input type="hidden" class="size_price"
                                                       value="{{$product['size_price']}}">
                                                <input type="hidden"
                                                       id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                                       value="{{$product['stock']}}">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                          <button type="button"
                                                                  class="btn btn-default btn-number reducing"
                                                                  @if($product['qty'] <= 1) disabled="disabled"
                                                                  @endif data-type="minus"
                                                                  data-field="quant[1]">
                                                              <span class="glyphicon glyphicon-minus"></span>
                                                          </button>
                                                    </span>
                                                    <input id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                                           type="text" name="quant[1]" class="form-control input-number"
                                                           disabled
                                                           value="{{ $product['qty'] }}" min="1" max="999">
                                                    <span class="input-group-btn">
                                                      <button type="button" class="btn btn-default btn-number adding"
                                                              data-type="plus" data-field="quant[1]">
                                                          <span class="glyphicon glyphicon-plus"></span>
                                                      </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="a-right movewishlist">
                                            <span class="cart-price">
                                                <span class="price"
                                                      id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                                                    {{ number_format(round($product['price'], 1), 2, ",", ".") }}
                                                </span>
                                            </span>
                                            </td>
                                            <td class="a-center last">
                                                <span class="removecart cart-remove"
                                                      data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}"
                                                      data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"></span>
                                            </td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr class="first odd">
                                        <td colspan="4">{{ __('front.no_item_in_cart') }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </fieldset>
                    </form>
                </div>

                {{-- BEGIN CART COLLATERALS  --}}


                <div class="cart-collaterals container">
                    {{-- BEGIN COL2 SEL COL 1  --}}
                    <div class="row">

                        <div class="col-sm-6">

                            <div class="discount">
                                <h3>{{ __('front.discount_codes') }} </h3>
                                <form id="discount-coupon-form" action="#" method="post">
                                    <label for="coupon_code">{{ __('front.discount_codes_text') }}</label>
                                    <input type="hidden" name="remove" id="remove-coupone" value="0">
                                    <input class="input-text fullwidth" type="text" id="coupon_code" name="coupon_code"
                                           value="">
                                    <button type="button" title="{{ __('front.apply_coupon') }}"
                                            class="button coupon "
                                            onClick="discountForm.submit(false)" value="Apply Coupon">
                                        <span>{{ __('front.apply_coupon') }} </span></button>

                                </form>

                            </div> {{--discount --}}
                        </div> {{--col-sm-4 --}}

                        <div class="col-sm-6">
                            <div class="totals">
                                <h3>{{ __('front.cart_total') }}</h3>
                                <div class="inner">

                                    <table id="shopping-cart-totals-table" class="table shopping-cart-table-total">
                                        <colgroup>
                                            <col>
                                            <col width="1">
                                        </colgroup>
                                        <tfoot>
                                        <tr>
                                            <td style="" class="a-left" colspan="1">
                                                <strong>{{ __('front.grand_total') }}</strong>
                                            </td>
                                            <td style="" class="a-right">
                                                <strong>
                                                    <span class="price main-total">₺{{ Session::has('cart') ? number_format(round($mainTotal, 1), 2, ",", ".") : '0.00' }}</span>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tfoot>

                                        <tbody>
                                            <tr>
                                                <td style="" class="a-left" colspan="1">
                                                    {{ __('front.subtotal') }}
                                                </td>
                                                <td style="" class="a-right">
                                                    <span class="price main-total">₺{{ Session::has('cart') ? number_format(round($subTotal, 1), 2, ",", ".") : '0.00' }}</span>
                                                </td>
                                            </tr>
                                        @if(Session::has('cart'))
                                            <tr>
                                                <td style="" class="a-left" colspan="1">
                                                    {{ __('front.cargo') }}
                                                </td>
                                                <td style="" class="a-right">
                                                    <span class="price" id="cargo-price">₺{{ number_format($cargoPrice, 2, ",", ".") }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>

                                    </table>

                                    <ul class="checkout">
                                        <li>
                                            <button type="button" title="{{ __('front.proceed_to_checkout') }}"
                                                    class="button btn-proceed-checkout"
                                                    onClick="location.href='{{ route('front.checkout') }}'"
                                                    @if(!Session::has('cart')) disabled @endif>
                                                <span>{{ __('front.proceed_to_checkout') }}</span>
                                            </button>
                                        </li>

                                    </ul>
                                </div>{{--inner --}}
                            </div>{{--totals --}}
                        </div> {{--col-sm-4 --}}


                    </div> {{--cart-collaterals --}}


                </div>
            </div> {{--cart --}}

        </div>{{--main-container --}}

    </div> {{--col1-layout --}}

@endsection

@section('theme::scripts')

@endsection