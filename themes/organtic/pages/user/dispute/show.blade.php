@extends('theme::layouts.app')

@section('theme::title', __('auth.disputes'))

@section('theme::styles')
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
                        <div class="header-area">
                            <div class="row">
                                <div class="col-sm-10">
                                    @if( $conv->order_number != null )
                                        <h4 class="title">
                                            {{ __('front.order-number') }}: {{ $conv->order_number }}
                                        </h4>
                                    @endif
                                    <h4 class="title">
                                        {{ __('front.subject') }}: {{$conv->subject}} @if( $conv->status === 2 ) <span
                                                class="text-success font-weight-bold"> [Sorun Çözüldü] </span> @endif
                                    </h4>
                                </div>
                                @if( $conv->status != 2 )
                                    <div class="col-sm-2">
                                        <a href="{{ route('user-message-solve',$conv->uuid ) }}"
                                           class="mybtn1">
                                            <i class="fa fa-check"></i> {{ __('front.dispute-close') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="support-ticket-wrapper ">
                            <div class="panel">
                                <div class="gocover"
                                     style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                <div class="panel-body" id="messages">
                                    @foreach($conv->messages as $message)
                                        @if($message->user_id != 0)
                                            <div class="single-reply-area user">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="reply-area">
                                                            <div class="left">
                                                                <p>{{$message->message}}</p>
                                                            </div>
                                                            <div class="right">
                                                                @if($message->conversation->user->is_provider == 1)
                                                                    <img class="img-circle"
                                                                         src="{{$message->conversation->user->photo != null ? $message->conversation->user->photo : asset('assets/images/noimage.png')}}"
                                                                         alt="">
                                                                @else

                                                                    <img class="img-circle"
                                                                         src="{{$message->conversation->user->photo != null ? asset('assets/images/users/'.$message->conversation->user->photo) : asset('assets/images/noimage.png')}}"
                                                                         alt="">

                                                                @endif
                                                                <p class="ticket-date">{{$message->conversation->user->name}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        @else
                                            <div class="single-reply-area admin">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="reply-area">
                                                            <div class="left">
                                                                <img class="img-circle"
                                                                     src="{{ asset('assets/images/admin.jpg')}}"
                                                                     alt="">
                                                                <p class="ticket-date">{{ $langg->lang399 }}</p>
                                                            </div>
                                                            <div class="right">
                                                                <p>{{$message->message}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        @endif
                                    @endforeach

                                </div>
                                @if( $conv->status != 2 )
                                    <div class="panel-footer">
                                        <form id="messageform" data-href="{{ route('user-message-load',$conv->uuid) }}"
                                              action="{{route('user-message-store')}}" method="POST">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <input type="hidden" name="conversation_id" value="{{$conv->id}}">
                                                <input type="hidden" name="user_id" value="{{$conv->user->id}}">
                                                <textarea class="form-control" name="message" id="wrong-invoice"
                                                          rows="5" style="resize: vertical;" required=""
                                                          placeholder="{{ __('front.message') }}"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="mybtn1">
                                                    {{ __('front.send') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>


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

    <script>
        // MESSAGE FORM

        $(document).on('submit', '#messageform', function (e) {
            e.preventDefault();
            var href = $(this).data('href');

            $('.gocover').show();

            $('button.mybtn1').prop('disabled', true);
            $.ajax({
                method: "POST",
                url: $(this).prop('action'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if ((data.errors)) {
                        $('.alert-success').hide();
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in data.errors) {
                            $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>')
                        }
                        $('#messageform textarea').val('');
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.alert-success p').html(data);
                        $('#messageform textarea').val('');
                        $('#messages').load(href);
                    }

                    $('.gocover').hide();

                    $('button.mybtn1').prop('disabled', false);
                }
            });
        });

        // MESSAGE FORM ENDS
    </script>

@endsection