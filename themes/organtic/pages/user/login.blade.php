@extends('theme::layouts.app')

@section('theme::title', __('auth.Login'))

@section('theme::styles')

    <link rel="stylesheet" href="{{ asset('themes/organtic/assets/css/user/login.css?v=0.0.4') }}" media="all" />

@endsection

@section('theme::content')
    <!-- BEGIN Main Container -->

    {{--
    <div class="main-container col1-layout wow bounceInUp animated animated" style="visibility: visible;">

        <div class="main">
            <div class="account-login container">
                <!--page-title-->

                <form action="{{ route('user.login.submit') }}" method="POST" id="loginform">
                    {{ csrf_field() }}
                    <fieldset class="col2-set">
                        <div class="col-1 new-users">
                            <strong>{{ __('auth.Register') }}</strong>
                            <div class="content">

                                <p>{{ __('auth.Register_Desc') }}</p>
                                <div class="buttons-set">
                                    <!-- Open Register Modal -->
                                    <button type="button" title="Create an Account" class="button create-account"><span><span>{{ __('auth.Register') }}</span></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 registered-users">
                            @include('includes.admin.form-login')
                            <strong>{{ __('auth.Login_Header') }}</strong>
                            <div class="content">

                                <ul class="form-list">
                                    <li>
                                        <label for="email">{{ __('auth.Email_Address') }}<em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="email" name="email" id="email"
                                                   class="input-text required-entry validate-email" title="Email Address">
                                        </div>
                                    </li>
                                    <li>
                                        <label for="pass">{{ __('auth.Password') }}<em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="password" name="password"
                                                   class="input-text required-entry validate-password" id="pass" title="Password">
                                        </div>
                                    </li>
                                </ul>
                                <p class="required">* {{ __('auth.Required_Fields') }}</p>
                                <div class="buttons-set">

                                    <button type="submit" class="button login" title="Login" name="send"
                                            id="send2"><span>{{ __('auth.Login') }}</span></button>

                                    <!-- Open Pass Forgot Modal -->
                                    <a href="#modal" class="forgot-word">{{ __('auth.Forgot_Password') }}</a>
                                </div>
                                <!--buttons-set-->
                            </div>
                            <!--content-->
                        </div>
                        <!--col-2 registered-users-->
                    </fieldset>
                    <!--col2-set-->
                </form>

            </div>
            <!--account-login-->

        </div>
        <!--main-container-->

    </div>
--}}
    <!--col1-layout-->

    <div class="forms">
        <ul class="tab-group">
            <li class="tab active"><a href="#loginform">{{ __('auth.Login') }}</a></li>
            <li class="tab"><a href="#signup">{{ __('auth.Register') }}</a></li>
        </ul>
        <form action="{{ route('user.login.submit') }}" method="POST" id="loginform">
            @include('includes.admin.form-login')
            <div class="input-field">
                {{ csrf_field() }}
                <input type="email" name="email" required="email" placeholder="{{ __('auth.Email_Address') }}"/>
                <input type="password" name="password" required placeholder="{{ __('auth.Password') }}"/>
                <input type="submit" value="{{ __('auth.Login') }}" class="button"/>
                <p class="text-p"> <a href="#">{{ __('auth.Forgot_Password') }}</a> </p>
            </div>
        </form>
        <form action="#" id="signup">
            @include('includes.admin.form-login')
            <div class="input-field">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="firstname" placeholder="{{ __('auth.Firstname') }}" required />
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="lastname" placeholder="{{ __('auth.Surname') }}" required />
                        </div>
                    </div>

                </div>
                <input type="email" name="email" placeholder="{{ __('auth.Email') }}" required="email"/>
                <input type="password" name="password" placeholder="{{ __('auth.Password') }}" required/>
                <input type="password" name="password_confirmation" placeholder="{{ __('auth.Confirm_Password') }}" required/>
                <input type="submit" value="{{ __('auth.Register') }}" class="button" />
            </div>
        </form>
    </div>

    @include('theme::partials.user.login.footer')

@endsection

@section('theme::scripts')
    <script src="{{ asset('themes/organtic/assets/js/user/events.js?v=0.0.3') }}"></script>

@endsection