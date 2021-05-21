@extends('layouts.load')

@section('content')
    <div class="content-area">

        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('includes.admin.form-error')
                            <form id="parionformdata" action="{{route('admin-shipper-rates-update', $shipper->id)}}"
                                  method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="row text-center">
                                    <div class="col-12">
                                        <h4>{{ $shipper->shipper }} Fiyatları</h4>
                                    </div>
                                </div>


                                @foreach($rates as $rate)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="left-area">
                                                <h4 class="heading">{{ $rate->rate_start }} - {{ $rate->rate_end }} Desi</h4>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" class="input-field" name="rate[{{$rate->id}}][value]"
                                                   placeholder="Ücret Giriniz" @if ($loop->first) required="" @endif
                                                   value="{{ $rate->shipperRate->value ?? '' }}">
                                            <input type="hidden" name="rate[{{$rate->id}}][id]"
                                                   value="{{ $rate->shipperRate->id ?? '0' }}">
                                        </div>
                                    </div>
                                @endforeach


                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">

                                        </div>
                                    </div>
                                    <div class="col-lg-7">
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
