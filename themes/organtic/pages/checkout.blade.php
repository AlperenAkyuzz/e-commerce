@extends('theme::layouts.app')

@section('theme::title', __('front.checkout'))

@section('theme::styles')

@endsection

@section('theme::content')
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <ul class="nav nav-tabs" role="tablist">

                                <li role="presentation" class="active">
                                    <a href="#information" data-toggle="tab" aria-controls="step1" role="tab" title="{{ __('front.personal_information') }}">
                                <span class="round-tab">
                                    <i class="far fa-address-card"></i>
                                </span>
                                    </a>
                                </li>

                                <li role="presentation" class="disabled">
                                    <a href="#orders" data-toggle="tab" aria-controls="step2" role="tab" title="{{ __('front.orders') }}">
                                <span class="round-tab">
                                    <i class="fas fa-dolly"></i>
                                </span>
                                    </a>
                                </li>

                                <li role="presentation" class="disabled">
                                    <a href="#payment" data-toggle="tab" aria-controls="complete" role="tab"
                                       title="{{ __('front.payment') }}">
                                <span class="round-tab">
                                    <i class="far fa-credit-card"></i>
                                </span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <form id="" action="{{ route('garanti-submit') }}" method="POST" class="checkoutform">
                            @include('includes.form-success')
                            @include('includes.form-error')

                            {{ csrf_field() }}

                            <div class="error-message">

                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel" id="information">
                                    @include('theme::partials.checkout.information')
                                    <ul class="list-inline pull-right">
                                        <li>
                                            <button type="button" class="btn btn-main next-step">{{ __('front.continue') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="orders">
                                    @include('theme::partials.checkout.orders')
                                    <ul class="list-inline pull-right">
                                        <li>
                                            <button type="button" class="btn btn-back prev-step">{{ __('front.previous') }}</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-main next-step">{{ __('front.continue') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="payment">
                                    @include('theme::partials.checkout.payment')
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    Yan taraf
                </div>
            </div>
        </div>
    </section>
@endsection

@section('theme::scripts')

@endsection