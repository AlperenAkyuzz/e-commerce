@extends('theme::layouts.app')

@section('theme::title', __('auth.user-favorites'))

@section('theme::styles')
    <link rel="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endsection
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
                            <div class="recent-orders">
                                <div class="table-responsive">
                                    <table class="data-table table-striped" id="my-favorite-sellers">
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
                                            <th>{{ __('front.vendor') }}</th>
                                            <th>{{ __('front.address') }}</th>
                                            <th>{{ __('front.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($favorites as $vendor)
                                            @php
                                                $seller = App\Models\User::findOrFail($vendor->vendor_id);
                                            @endphp
                                            <tr class="conv">

                                                <td>{{$seller->shop_name}}</td>
                                                <td>{{$seller->shop_address}}</td>

                                                <td>
                                                    <a target="_blank"
                                                       href="{{route('front.vendor',str_replace(' ', '-',($seller->shop_name)))}}"
                                                       class="link view"><i class="fa fa-eye"></i></a>
                                                    <a href="javascript:;" data-toggle="modal"
                                                       data-target="#confirm-delete"
                                                       data-href="{{route('user-favorite-delete',$vendor->id)}}"
                                                       class="link remove"><i class="fa fa-trash"></i></a>
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
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header d-block text-center">
                                <h4 class="modal-title d-inline-block">{{ __('front.confirm_delete') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <p class="text-center">{{ __('front.confirm_delete_title') }}</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('front.cancel') }}</button>
                                <a class="btn btn-danger btn-ok">{{ __('front.delete') }}</a>
                            </div>
                        </div>
                    </div>
                </div>



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
        $(document).ready(function () {
            $('#my-favorite-sellers').DataTable({
                "bFilter": false,
                "lengthChange": false,
                "language": {
                    "url": mainurl + "/themes/organtic/assets/lang/datatables/Turkish.json"
                }
            });

            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });

        });
    </script>

@endsection