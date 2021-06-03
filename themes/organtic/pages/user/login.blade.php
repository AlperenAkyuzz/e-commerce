@extends('theme::layouts.app')

@section('theme::title', __('auth.Login'))

@section('theme::styles')
    <style>

    </style>

@endsection

@section('theme::content')
    <!-- BEGIN Main Container -->

    <div class="forms user-action-form">
        <ul class="tab-group">
            <li class="tab active"><a href="#user-login">{{ __('auth.Login') }}</a></li>
            <li class="tab"><a href="#user-signup">{{ __('auth.Register') }}</a></li>
        </ul>
        <form action="{{ route('user.login.submit') }}" method="POST" id="user-login">
            @include('includes.admin.form-login')
            <div class="input-field">
                {{ csrf_field() }}
                <input type="email" name="email" required="email" placeholder="{{ __('auth.Email_Address') }}"/>
                <input type="password" name="password" required placeholder="{{ __('auth.Password') }}"/>
                <input type="submit" value="{{ __('auth.Login') }}" class="button"/>
                <p class="text-p"><a href="#">{{ __('auth.Forgot_Password') }}</a></p>
            </div>
        </form>
        <form action="{{route('user-register-submit')}}" method="POST" id="user-signup">
            @include('includes.admin.form-login')
            <div class="input-field">
                {{ csrf_field() }}
                <input type="text" name="name" placeholder="{{ __('auth.Fullname') }}" required=""/>
                <input type="email" name="email" placeholder="{{ __('auth.Email') }}" required=""/>
                <input type="tel" name="phone" placeholder="{{ __('auth.Phone') }}" required=""/>
                <input type="text" name="address" placeholder="{{ __('auth.Address') }}" required=""/>
                <input type="password" name="password" placeholder="{{ __('auth.Password') }}" required=""/>
                <input type="password" name="password_confirmation" placeholder="{{ __('auth.Confirm_Password') }}"
                       required/>
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <input class="mprocessdata" type="hidden" value="{{ __('auth.Processing...') }}">
                <input type="submit" data-action='submit' value="{{ __('auth.Register') }}" class="button"/>
            </div>
        </form>
    </div>

    @include('theme::widgets.services')

@endsection

@section('theme::scripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6Lcb9OMaAAAAAB_qFZxE4YQowBQwC6YZpV1KxUSx"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ $gs->recaptcha_site }}', {action: 'validate_captcha'}).then(function (token) {
                $('#g-recaptcha-response').val(token);
            });
        });

        $("#user-signup").on('submit', function (e) {
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ $gs->recaptcha_site }}', {action: 'submit'}).then(function (token) {
                    $('#g-recaptcha-response').val(token);
                });
            });
        });

    </script>
@endsection
