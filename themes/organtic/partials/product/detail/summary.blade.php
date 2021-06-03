@php
    $attrPrice = 0;

    if($product->user_id != 0){
        $vendor = \App\Models\User::find($product->user_id);

        //$attrPrice = $product->price + $gs->fixed_commission + ($product->price/100) * $gs->percentage_commission ;
        $attrPrice = $product->price + ($product->price/100) * $vendor->vendor_commission ;

      } else {
        $attrPrice = $product->price;
      }


  if(!empty($product->size) && !empty($product->size_price)){
        $attrPrice += $product->size_price[0];
    }

    if(!empty($product->attributes)){
      $attrArr = json_decode($product->attributes, true);
    }
    $attrPrice = round($attrPrice + ($attrPrice * $product->tax) / 100, 1);
@endphp

@if (!empty($attrArr))
    @foreach ($attrArr as $attrKey => $attrVal)
        @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)
            @foreach ($attrVal['values'] as $optionKey => $optionVal)
                @if ($loop->first)
                    @if (!empty($attrVal['prices'][$optionKey]))
                        @php
                            $attrPrice = $attrPrice + $attrVal['prices'][$optionKey] * $curr->value;
                        @endphp
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach
@endif

@php
    $withSelectedAtrributePrice = $attrPrice+$product->price;
    $withSelectedAtrributePrice = round(($withSelectedAtrributePrice) * $curr->value,2);

@endphp

<div class="product-essential container">
    <div class="row">

        <form action="#" method="post" id="product_addtocart_form">
            <!--End For version 1, 2, 6 -->
            <!-- For version 3 -->
            <div class="product-img-box col-lg-5 col-sm-5 col-xs-12">
                <!--
                <div class="new-label new-top-left">Hot</div>
                <div class="sale-label sale-top-left">-15%</div>
                -->
                <div class="product-image">
                    <div class="product-full">
                        <img id="product-zoom"
                             src="{{ asset('assets/images/products/'.$product->photo) }}"
                             data-zoom-image="{{ asset('assets/images/products/'.$product->photo) }}"
                             alt="product-image"/>
                    </div>

                    <div class="more-views">
                        <div class="slider-items-products">
                            <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                                <div class="slider-items slider-width-col4 block-content">
                                    @foreach($product->galleries as $gallery)
                                        <div class="more-views-items">
                                            <a href="#"
                                               data-image="{{ asset('assets/images/galleries/'.$gallery->photo) }}"
                                               data-zoom-image="{{ asset('assets/images/galleries/'.$gallery->photo) }}">
                                                <img id="product-zoom{{ $loop->iteration - 1 }}"
                                                     src="{{ asset('assets/images/galleries/'.$gallery->photo) }}"
                                                     alt="product-image"/>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: more-images -->
            </div>
            <!--End For version 1,2,6-->
            <!-- For version 3 -->
            <div class="product-shop col-lg- col-sm-7 col-xs-12">
                @if(isset($product->brand->title))
                    <div class="brand">Marka: {{ $product->brand->title }}</div>
                @endif
                <div class="product-name">
                    <h1>{{ $product->name }} </h1>
                </div>
                <div class="ratings">
                    <div class="rating-box">
                        @php
                            $rate = ceil($product->ratings->avg('rating'));
                        @endphp
                        <div style="width:{{ (100 * $rate / 5) }}%" class="rating"></div>
                    </div>
                    <p class="rating-links">
                        <a href=""
                           data-href="#productTabContent">{{ __('front.review_count', ['count' => $product->ratings->count()])}}
                        </a>
                        {{--<span class="separator">|</span> <a href="#">{{ __('front.add_review') }}</a>--}}

                    </p>
                </div>
                <div class="vendor-block">
                    {{ __('front.vendor') }}:
                <!--
            <span class="vendor"> {{ __('front.vendor') }} : <a href="{{ route('front.vendor',str_replace(' ', '-', $product->user->shop_name)) }}">{{ $product->user->shop_name }} </a></span>
              -->
                    @if( $product->user_id  != 0)
                        @if(isset($product->user))
                            <a href="{{ route('front.vendor',str_replace(' ', '-', $product->user->shop_name)) }}"
                               class="view-stor">{{ $product->user->shop_name }}</a>


                    @else
                        {{ $langg->lang247 }}
                    @endif
                @else
                    {{ App\Models\Admin::find(1)->shop_name }}
                @endif
                <!--<span class="vendor-rating">Puan: 10,0</span>-->
                </div>
                <div class="price-block">
                    <div class="price-box">
                        @if($product->stock > 0)
                            <p class="availability in-stock"><span>{{ __('front.in_stock') }}</span></p>
                        @else
                            <p class="availability no-stock"><span>{{ __('front.no_stock') }}</span></p>
                        @endif

                        <p class="special-price">
                            @if($product->previous_price > $product->price )
                                <del>{{ $product->showPreviousPrice() }}</del>
                            @endif
                            <span id="product-price-48" class="price"
                                  data-price="{{number_format($attrPrice,2)}}">₺{{number_format($attrPrice,2,",",".")}}</s></span>
                        </p>


                    </div>
                </div>
                @if(!empty($product->size))
                    <div class="product-size">
                        <p class="title">{{ $langg->lang88 }} :</p>
                        <ul class="siz-list">
                            @php
                                $is_first = true;
                            @endphp
                            @foreach($product->size as $key => $data1)
                                <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box">{{ $data1 }}
                          <input type="hidden" class="size" value="{{ $data1 }}">
                          <input type="hidden" class="size_qty" value="{{ $product->size_qty[$key] }}">
                          <input type="hidden" class="size_key" value="{{$key}}">
                          <input type="hidden" class="size_price"
                                 value="{{ round($product->size_price[$key] * $curr->value,2) }}">
                        </span>
                                </li>
                                @php
                                    $is_first = false;
                                @endphp
                            @endforeach
                            <li>
                        </ul>
                    </div>
                @endif

                @if(!empty($product->color))
                    <div class="product-color">
                        <p class="title">{{ $langg->lang89 }} :</p>
                        <ul class="color-list">
                            @php
                                $is_first = true;
                            @endphp
                            @foreach($product->color as $key => $data1)
                                <li class="{{ $is_first ? 'active' : '' }}">
                                    <span class="box" data-color="{{ $product->color[$key] }}"
                                          style="background-color: {{ $product->color[$key] }}"></span>
                                </li>
                                @php
                                    $is_first = false;
                                @endphp
                            @endforeach

                        </ul>
                    </div>
                @endif
                @if (!empty($product->attributes))
                    @php
                        $attrArr = json_decode($product->attributes, true);
                    @endphp
                @endif
                @if (!empty($attrArr))
                    <div class="product-attributes my-4">
                        <div class="row">
                            @foreach ($attrArr as $attrKey => $attrVal)
                                @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                                    <div class="col-lg-6">
                                        <div class="form-group mb-2">
                                            <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }}
                                                :</strong>
                                            <div class="">
                                                @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                                    @if ($loop->first)
                                                        @if (!empty($attrVal['prices'][$optionKey]))
                                                            @php
                                                                $attrPrice = $attrPrice + $attrVal['prices'][$optionKey] * $curr->value;
                                                            @endphp
                                                        @endif
                                                    @endif


                                                    <div class="custom-control custom-radio">
                                                        <input type="hidden" class="keys" value="">
                                                        <input type="hidden" class="values" value="">
                                                        <input type="radio" id="{{$attrKey}}{{ $optionKey }}"
                                                               name="{{ $attrKey }}"
                                                               class="custom-control-input product-attr"
                                                               data-key="{{ $attrKey }}"
                                                               data-price="{{ $attrVal['prices'][$optionKey] * $curr->value }}"
                                                               value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="{{$attrKey}}{{ $optionKey }}"><span></span>{{ $optionVal }}

                                                            @if (!empty($attrVal['prices'][$optionKey]))
                                                                +
                                                                {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                @php

                        @endphp
                @if($product->stock > 0)
                    <div class="add-to-box">
                        <div class="add_cart">
                            <div class="pull-left">
                                <div class="custom pull-left">
                                    <button
                                            onclick="//var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 0 ) result.value--;return false;"
                                            class="reduced items-count qtminus" type="button"><i class="fa fa-minus">&nbsp;</i>
                                    </button>
                                    <input type="number" class="input-text qty" title="Qty" value="1"
                                           min="1" max="{{ $product->stock }}" id="qty"
                                           name="qty"
                                           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    >
                                    <button
                                            onclick="//var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) if (this.value.length > this.maxLength) return false; else result.value++; return false;"
                                            class="increase items-count qtplus" type="button"><i class="fa fa-plus">&nbsp;</i>
                                    </button>
                                </div>
                            </div>
                            <button class="button btn-cart" id="addcrt"
                                    title="{{ __('front.add_cart') }}"
                                    type="button">{{ __('front.add_cart') }}</button>

                        </div>
                    </div>
                @endif
                <div class="short-description">
                    <p>{{ $product->summary }}</p>
                </div>
                <div class="email-addto-box">
                    <ul class="add-to-links">
                        <li>
                            @if (Auth::guest())
                                <a class="link-wishlist" href="{{ url('/giris') }}">
                                    <span>{{ __('front.add_wishlist') }}</span>
                                </a>
                            @else

                                <a class="link-wishlist add-to-wish" href="javascript:void(0);"
                                   data-href="{{ route('user-wishlist-add',$product->id) }}">
                                    <span>{{ __('front.add_wishlist') }}</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
                <!--
                <div class="social">
                  <ul class="link">
                    <li class="fb"><a href="#"></a></li>
                    <li class="tw"><a href="#"></a></li>
                    <li class="googleplus"><a href="#"></a></li>
                    <li class="rss"><a href="#"></a></li>
                    <li class="pintrest"><a href="#"></a></li>
                    <li class="linkedin"><a href="#"></a></li>
                    <li class="youtube"><a href="#"></a></li>
                  </ul>
                </div>-->

                <ul class="shipping-pro">
                    <li>Free Wordwide Shipping</li>
                    <li>30 Days Return</li>
                    <li>Member Discount</li>
                </ul>
            </div>
            <!--product-shop-->
            <!--Detail page static block for version 3-->
        </form>
    </div>
</div>