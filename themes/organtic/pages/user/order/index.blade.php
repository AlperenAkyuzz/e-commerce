@extends('theme::layouts.app')

@section('theme::title', __('auth.my-account'))

@section('theme::styles')
    <link rel="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endsection
@inject('OrderStatusType', 'App\Models\Order')
@section('theme::content')


    <!-- BEGIN Main Container col2-right -->
    <section class="main-container col2-right-layout">
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
                                    <strong>{{ __('auth.hello', ['name' => Auth::user()->name ]) }}</strong></p>
                                <p>{{ __('auth.dashboard_subtitle') }}</p>
                            </div>
                            <div class="recent-orders">
                                <div class="table-responsive">
                                    <table class="data-table table-striped" id="my-orders-table">
                                        <colgroup>
                                            <col width="">
                                            <col width="">
                                            <col>
                                            <col width="1">
                                            <col width="1">
                                            <col width="20%">
                                        </colgroup>
                                        <thead>
                                        <tr class="first last">
                                            <th>{{ __('front.order-id') }}</th>
                                            <th>{{ __('front.date') }}</th>
                                            <th><span class="nobr">{{ __('front.order-total') }}</span></th>
                                            <th>{{ __('front.order-status') }}</th>
                                            <th>{{ __('front.view') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(Auth::user()->orders()->latest()->get() as $order)
                                            <tr class="first odd">
                                                <td>{{$order->order_number}}</td>
                                                <td>
                                                    <span class="nobr">{{ $order->ordered_at() }}</span>
                                                </td>
                                                <td>
                                                    <span class="price">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</span>
                                                </td>
                                                <td class="order-status {{ $order->status }}">{{ $OrderStatusType::status[$order->status] }}</td>
                                                <td class="a-center last">
                                                <span class="nobr">
                                                    <a href="{{route('user-order',$order->id)}}">{{ __('front.view') }}</a>
                                                </span>
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
        $(document).ready(function() {
            $('#my-orders-table').DataTable( {
                "bFilter": false,
                "lengthChange": false,
                "language": {
                    "url": mainurl + "/themes/organtic/assets/lang/datatables/Turkish.json"
                }
            });
        } );
    </script>

@endsection