@extends('theme::layouts.app')

@section('theme::title', __('auth.my-account'))

@section('theme::styles')
    <link rel="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <style>
        .order-details .mybtn1 {
            width: 125px;
        }
    </style>
@endsection
@inject('OrderModel', 'App\Models\Order')
@section('theme::content')


    <!-- BEGIN Main Container col2-right -->
    <section class="main-container col2-right-layout user-container">
        <div class="main container">
            <div class="row">

                @include('theme::partials.user.panel.nav')

                <section class="col-main col-sm-9 col-xs-12 wow bounceInUp animated animated"
                         style="visibility: visible;">
                    <div class="my-account">

                        <!--page-title-->
                        <!-- BEGIN DASHBOARD-->

                        <div class="dashboard">
                            <div class="welcome-msg">
                                <p class="hello">
                                    <strong>{{ __('front.order-details') }}</strong></p>
                            </div>
                            <div class="order-details">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <p class="hello">
                                            <strong>{{ __('front.order') }} #{{$order->order_number}} <span class="order-status">[{{$OrderModel::status[$order->status]}}]</span></strong>
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{route('user-order-print',$order->id)}}" target="_blank"
                                           class="mybtn1">
                                            <i class="fa fa-print"></i> {{ __('front.print') }}
                                        </a>
                                    </div>
                                </div>

                                <div class="shipping-add-area">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($order->shipping == "shipto")
                                                <h5>{{ __('front.shipping_information') }}</h5>
                                                <address>
                                                    {{ __('auth.Name') }}:
                                                    {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}
                                                    <br>
                                                    {{ __('auth.Email') }}:
                                                    {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}
                                                    <br>
                                                    {{ __('auth.Phone') }}:
                                                    {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}
                                                    <br>
                                                    {{ __('auth.Address') }}:
                                                    {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}
                                                    <br>
                                                    {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}
                                                    -{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                </address>
                                            @else
                                                <h5>{{ __('front.pickup_location') }}</h5>
                                                <address>
                                                    {{ __('auth.Address') }}: {{$order->pickup_location}}<br>
                                                </address>
                                            @endif

                                        </div>
                                        <div class="col-md-6">
                                            <h5>{{ __('front.shipping_method') }}:</h5>
                                            @if($order->shipping == "shipto")
                                                <p>{{ __('front.ship_to_address') }}</p>
                                            @else
                                                <p>{{ __('front.pick_up') }}</p>
                                            @endif

                                            @if($order->shipping_cost != 0)
                                                @php
                                                    $price = round(($order->shipping_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                                    <p>
                                                        {{ DB::table('shippings')->where('price','=',$price)->first()->title }}
                                                        : {{$order->currency_sign}}{{ round($order->shipping_cost, 2) }}
                                                    </p>
                                                @endif
                                            @endif

                                            @if($order->packing_cost != 0)

                                                @php
                                                    $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                @endphp


                                                @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                                    <p>
                                                        {{ DB::table('packages')->where('price','=',$pprice)->first()->title }}
                                                        : {{$order->currency_sign}}{{ round($order->packing_cost, 2) }}
                                                    </p>
                                                @endif
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                <div class="billing-add-area">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>{{ __('front.billing_information') }}</h5>
                                            <address>
                                                {{ __('auth.Name') }}: {{$order->customer_name}}<br>
                                                {{ __('auth.Email') }}: {{$order->customer_email}}<br>
                                                {{ __('auth.Phone') }}: {{$order->customer_phone}}<br>
                                                {{ __('auth.Address') }}: {{$order->customer_address}}<br>
                                                @if($order->order_note != null)
                                                    {{ __('front.order_note') }}: {{$order->order_note}}<br>
                                                @endif
                                                {{$order->customer_city}}-{{$order->customer_zip}}
                                            </address>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>{{ __('front.payment_information') }}</h5>

                                            <p>{{ __('front.payment_status') }}
                                                {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                            </p>


                                            <p>{{ __('front.paid_amount') }}:
                                                {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                            </p>
                                            <p>{{ __('front.payment_method') }}: {{$OrderModel::method[$order->method]}}</p>

                                            @if($order->method != "Cash On Delivery")
                                                @if($order->method=="Stripe")
                                                    {{$order->method}} {{ $langg->lang295 }}
                                                    <p>{{$order->charge_id}}</p>
                                                @endif
                                                {{$OrderModel::method[$order->method] }} {{ __('front.transaction_id') }} <p
                                                        id="ttn"> {{$order->txnid}}</p>

                                                <a id="tid" style="cursor: pointer;"
                                                   class="mybtn2">{{ __('front.edit') }}</a>

                                                <form id="tform">
                                                    <input style="display: none; width: 100%;" type="text" id="tin"
                                                           placeholder="{{  __('front.enter_transaction_id') }}"
                                                           required="" class="input-field mb-3">
                                                    <input type="hidden" id="oid" value="{{$order->id}}">

                                                    <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                            id="tbtn" type="submit"
                                                            class="mybtn1">{{ __('front.submit') }}</button>

                                                    <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                                       id="tc" class="mybtn1">{{ __('front.cancel') }}</a>

                                                    {{-- Change 1 --}}
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <h3>{{ __('front.products') }}</h3>
                                    <table class="data-table table-striped" id="my-orders-table">
                                        <thead>
                                        <tr class="first last">
                                            <th>{{ __('front.product_name') }}</th>
                                            <th><span class="nobr">{{ __('front.attributes') }}</span></th>
                                            <th>{{ __('front.price') }}</th>
                                            <th>{{ __('front.total') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cart->items as $product)
                                            <tr class="first odd">
                                                <td>
                                                    <input type="hidden" value="{{ $product['license'] }}">

                                                    @if($product['item']['user_id'] != 0)
                                                        @php
                                                            $user = App\Models\User::find($product['item']['user_id']);
                                                        @endphp
                                                        @if(isset($user))
                                                            <a target="_blank"
                                                               href="{{ url($product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                        @else
                                                            <a target="_blank"
                                                               href="{{ url($product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                        @endif
                                                    @else

                                                        <a target="_blank" class="d-block"
                                                           href="{{ url($product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>

                                                    @endif
                                                    @if($product['item']['type'] != 'Physical')
                                                        @if($order->payment_status == 'Completed')
                                                            @if($product['item']['file'] != null)
                                                                <a href="{{ route('user-order-download',['slug' => $order->order_number , 'id' => $product['item']['id']]) }}"
                                                                   class="btn btn-sm btn-primary mt-1">
                                                                    <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                                </a>
                                                            @else
                                                                <a target="_blank" href="{{ $product['item']['link'] }}"
                                                                   class="btn btn-sm btn-primary mt-1">
                                                                    <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                                </a>
                                                            @endif
                                                            @if($product['license'] != '')
                                                                <a href="javascript:;" data-toggle="modal"
                                                                   data-target="#confirm-delete"
                                                                   class="btn btn-sm btn-info product-btn mt-1"
                                                                   id="license"><i
                                                                            class="fa fa-eye"></i> {{ $langg->lang317 }}
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>{{ __('front.quantity') }} </b>: {{$product['qty']}} <br>
                                                    @if(!empty($product['keys']))

                                                        @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                            <b>{{ ucwords(str_replace('_', ' ', $key))  }}
                                                                : </b> {{ $value }} <br>
                                                        @endforeach

                                                    @endif

                                                </td>
                                                <td>
                                                    {{$order->currency_sign}}{{round($product['item_price'] * $order->currency_value,2)}}
                                                </td>
                                                <td>
                                                    {{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--table-responsive-->
                            </div>
                            <!--recent-orders-->
                        </div>
                    </div>
                </section>
                <!--col-main col-sm-9 wow bounceInUp animated-->

            </div>
            <!--row-->
        </div>
        <!--main container-->
    </section>
    <!--main-container col2-left-layout-->

@endsection

@section('theme::scripts')

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).on("click", "#tid", function (e) {
            $(this).hide();
            $("#tc").show();
            $("#tin").show();
            $("#tbtn").show();
        });
        $(document).on("click", "#tc", function (e) {
            $(this).hide();
            $("#tid").show();
            $("#tin").hide();
            $("#tbtn").hide();
        });
        $(document).on("submit", "#tform", function (e) {
            var oid = $("#oid").val();
            var tin = $("#tin").val();
            $.ajax({
                type: "GET",
                url: "{{URL::to('user/json/trans')}}",
                data: {
                    id: oid,
                    tin: tin
                },
                success: function (data) {
                    $("#ttn").html(data);
                    $("#tin").val("");
                    $("#tid").show();
                    $("#tin").hide();
                    $("#tbtn").hide();
                    $("#tc").hide();
                }
            });
            return false;
        });
    </script>
    <script>

        $(document).ready(function () {
            $('#my-orders-table').DataTable({
                "ordering": false,
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': false,
                'info': false,
                'autoWidth': false,
                "bFilter": false,
                "lengthChange": false,
                "language": {
                    "url": mainurl + "/themes/organtic/assets/lang/datatables/Turkish.json"
                }
            });
        });
    </script>

@endsection