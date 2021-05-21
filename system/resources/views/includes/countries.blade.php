<option value="">{{ __('front.select_country') }}</option>
@if(Auth::check())
	@foreach (DB::table('countries')->get() as $data)
	<option value="{{ $data->country_name }}" {{ Auth::user()->country == $data->country_name ? 'selected' : '' }}>{{ $data->country_name }}</option>
	@endforeach
@else
	@foreach (DB::table('countries')->get() as $data)
	<option value="{{ $data->country_name }}">{{ $data->country_name }}</option>
	@endforeach
@endif