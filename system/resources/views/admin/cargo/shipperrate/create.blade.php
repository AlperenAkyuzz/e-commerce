@extends('layouts.load')

@section('content')

    <div class="content-area">

        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('includes.admin.form-error')
                            <form id="parionformdata" action="{{route('admin-shipper-rates-create')}}" method="POST"
                                  enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Shipper') }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <select id="shipper" name="shipper_id" required="">
                                            <option value="">{{ __('Select Cargo Carrier') }}</option>
                                            @foreach($shippers as $shipper)
                                                <option value="{{ $shipper->id }}">{{ $shipper->shipper }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @foreach($rates as $rate)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="left-area">
                                                <h4 class="heading">{{ $rate->rate_start }} - {{ $rate->rate_end }}
                                                    Desi</h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" class="input-field" name="rate[{{$rate->id}}]"
                                                   placeholder="Ücret Giriniz" @if ($loop->first) required="" @endif
                                                   value="">

                                        </div>
                                    </div>
                                @endforeach


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
