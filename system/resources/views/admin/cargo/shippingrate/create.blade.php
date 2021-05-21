@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')
                      <form id="parionformdata" action="{{route('admin-shipping-rates-create')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                          <div class="row">
                              <div class="col-lg-4">
                                  <div class="left-area">
                                      <h4 class="heading">{{ __('Small Desi') }} *</h4>
                                      <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                  </div>
                              </div>
                              <div class="col-lg-7">
                                  <input type="text" class="input-field" name="rate_start"
                                         placeholder="{{ __('Small Desi') }}" required=""
                                         value="">
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-lg-4">
                                  <div class="left-area">
                                      <h4 class="heading">{{ __('Big Desi') }} *</h4>
                                      <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                  </div>
                              </div>
                              <div class="col-lg-7">
                                  <input type="text" class="input-field" name="rate_end"
                                         placeholder="{{ __('Big Desi') }}" required=""
                                         value="">
                              </div>
                          </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create') }}</button>
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
