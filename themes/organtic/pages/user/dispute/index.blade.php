@extends('theme::layouts.app')

@section('theme::title', __('auth.disputes'))

@section('theme::styles')
    <link rel="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <style>

        @media only screen and (max-width: 575px) {
            .message-modal .modal .modal-dialog {
                width: 100%;
            }
        }
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto;
            }
        }
    </style>
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
                            <div class="welcome-msg">
                                <a data-toggle="modal" data-target="#vendorform" class="mybtn1" href=""> <i class="fas fa-envelope"></i> {{ __('front.add-dispute') }}</a>
                            </div>
                            <div class="recent-orders">
                                <div class="table-responsive">
                                    <table class="data-table table-striped" id="my-disputes-table">
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
                                            <th>{{ __('front.subject') }}</th>
                                            <th>{{ __('front.message') }}</th>
                                            <th>{{ __('front.date') }}</th>
                                            <th>{{ __('front.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($convs as $conv)
                                            <tr class="conv">
                                                <input type="hidden" value="{{$conv->id}}">
                                                <td>{{$conv->subject}}</td>
                                                <td>{{$conv->message}}</td>

                                                <td>{{$conv->created_at->diffForHumans()}}</td>
                                                <td>
                                                    <a href="{{route('user-message-show',$conv->uuid)}}" class="link view"><i class="fa fa-eye"></i></a>
                                                    <a href="" data-toggle="modal" data-target="#confirm-delete" data-href="{{route('user-message-delete1',$conv->uuid)}}"class="link remove"><i class="fa fa-trash"></i></a>
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

    @include('theme::partials.user.panel.modals.message')
    @include('theme::partials.user.panel.modals.confirm-delete')

@endsection

@section('theme::scripts')

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#my-disputes-table').DataTable({
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

        $(document).on("submit", "#emailreply1" , function(){
            var token = $(this).find('input[name=_token]').val();
            var subject = $(this).find('input[name=subject]').val();
            var message =  $(this).find('textarea[name=message]').val();
            var $type  = $(this).find('input[name=type]').val();
            var order = $( "#order option:selected" ).val();//$('#order').val();
            console.log(order)
            $('#subj1').prop('disabled', true);
            $('#msg1').prop('disabled', true);
            $('#emlsub1').prop('disabled', true);
            $.ajax({
                type: 'post',
                url: "{{URL::to('/hesabim/sorun-bildir/send/message')}}",
                data: {
                    '_token': token,
                    'subject'   : subject,
                    'message'  : message,
                    'type'   : $type,
                    'order'  : order
                },
                success: function( data) {
                    $('#subj1').prop('disabled', false);
                    $('#msg1').prop('disabled', false);
                    $('#subj1').val('');
                    $('#msg1').val('');
                    $('#emlsub1').prop('disabled', false);
                    if(data == 0)
                        toastr.error("{{ trans('front.something_wrong') }}");
                    else
                        toastr.success("{{ trans('front.message-success') }}");
                    $('.close').click();
                }

            });
            return false;
        });
    </script>

@endsection