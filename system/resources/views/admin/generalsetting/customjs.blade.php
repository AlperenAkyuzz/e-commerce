@extends('layouts.admin')

@section('content')

    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Custom JS & CSS') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('General Settings') }}</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Custom JS & CSS') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            <div class="gocover"
                                 style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form id="parionform" action="{{ route('admin-gs-update-custom-js') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                @include('includes.admin.form-both')


                                <div class="row justify-content-center">
                                    <div class="col-lg-3">
                                        <div class="left-area">
                                            <h4 class="heading">
                                                {{ __('Custom JS Code') }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="tawk-area">
                                            <textarea name="js_code"
                                                      required="">{{ $jsContent }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-3">
                                        <div class="left-area">
                                            <h4 class="heading">
                                                {{ __('Custom CSS Code') }}

                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="tawk-area">
                                            <textarea name="css_code"
                                                      required="">{{ $cssContent }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row justify-content-center">
                                    <div class="col-lg-3">
                                        <div class="left-area">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
