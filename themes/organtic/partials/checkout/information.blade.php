<div class="section-information">
    <ol class="one-page-checkout" id="checkoutSteps">
        <li id="opc-billing" class="section allow active">
            <div class="step-title">
                <span class="number">1</span>
                <h3 class="one_page_heading"> {{ __('front.personal_information') }}</h3>
                <div id="checkout-step-billing" class="step a-item">
                    <fieldset class="group-select">
                        <ul class="">
                            <li id="billing-new-address-form">
                                <fieldset>
                                    <ul>
                                        <li class="fields">
                                            <div class="customer-name">
                                                <div class="input-box">
                                                    <div class="input-box1">
                                                        <input type="text" id="personal-name"
                                                               name="personal_name" placeholder="{{ __('front.enter_your_name') }}"
                                                               title="Your name" maxlength="255" required
                                                               class="input-text required-entry"
                                                               value="{{ Auth::check() ? Auth::user()->name : '' }}" {!! Auth::check() ? 'readonly' : '' !!}>
                                                    </div>
                                                </div>
                                                <div class="input-box">
                                                    <div class="input-box1">
                                                        <input type="email" id="personal-email"
                                                               name="personal_email" placeholder="{{ __('front.enter_your_mail') }}"
                                                               title="Email" maxlength="255" required
                                                               class="input-text required-entry"
                                                               value="{{ Auth::check() ? Auth::user()->email : '' }}" {!! Auth::check() ? 'readonly' : '' !!}>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @if(!Auth::check())
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <input class="styled-checkbox" id="open-pass"
                                                           type="checkbox" value="1" name="pass_check">
                                                    <label for="open-pass"><span></span>{{ __('front.create_an_account') }}</label>
                                                </div>
                                            </div>
                                            <div class="row set-account-pass d-none">
                                                <div class="col-lg-6 input-box1">
                                                    <input type="password" name="personal_pass"
                                                           id="personal-pass" class="input-text required-entry"
                                                           placeholder="{{ __('auth.Password') }}">
                                                </div>
                                                <div class="col-lg-6 ">
                                                    <input type="password" name="personal_confirm"
                                                           id="personal-pass-confirm" class="input-text required-entry"
                                                           placeholder="{{ __('auth.Confirm_Password') }}">
                                                </div>
                                            </div>
                                        @endif
                                    </ul>

                                </fieldset>
                            </li>
                        </ul>
                    </fieldset>
                </div>
            </div>

            {{-- Billing Address --}}
            <div class="step-title">
                <span class="number">2</span>
                <h3 class="one_page_heading"> {{ __('front.billing_information') }}</h3>
                <div id="checkout-step-billing" class="step a-item">
                    <fieldset class="group-select">
                        <ul class="">
                            <li id="billing-new-address-form">
                                <fieldset>
                                    <ul>
                                        <li class="fields">
                                            <div class="customer-name">
                                                <div class="input-box name-firstname">
                                                    <div class="input-box1">
                                                        <input type="text" id="billing:firstname"
                                                               name="name" placeholder="{{ __('front.enter_your_name') }}"
                                                               title="Your name" maxlength="255"
                                                               class="input-text required-entry" required
                                                               value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : '' }}">
                                                    </div>
                                                </div>
                                                <div class="input-box name-lastname">
                                                    <div class="input-box1">
                                                        <input type="email" id="billing:lastname"
                                                               name="email" placeholder="{{ __('front.enter_your_mail') }}"
                                                               title="Email" maxlength="255"
                                                               class="input-text required-entry" required
                                                               value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->email : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wide">
                                            <input type="text" title="Address" name="address"
                                                   id="billing:street1" required
                                                   placeholder="{{ __('front.address') }}" class="input-text  required-entry"
                                                   value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->address : '' }}">

                                        </li>
                                        <li class="fields">
                                            <div class="input-box">
                                                <label for="billing:city">{{ __('front.city') }}<em class="required">*</em></label>

                                                <input type="text" title="{{ __('front.city') }}" name="city" placeholder="{{ __('front.city') }}"
                                                       class="input-text input-city  required-entry" id="billing:city" required
                                                       value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->city : '' }}">

                                            </div>
                                            <div class="field">
                                                <label for="billing:region_id">{{ __('front.country') }}<em class="required">*</em></label><br>
                                                <div class="input-box">
                                                    <select id="billing:region_id" name="customer_country"
                                                            title="{{ __('front.country') }}" required
                                                            class="validate-select country-select required-entry" defaultvalue="1">
                                                        @include('includes.countries')
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="fields">
                                            <div class="input-box">
                                                <label for="billing:postcode">{{ __('front.zip_postal') }}<em class="required">*</em></label>

                                                <input type="text" title="{{ __('front.zip_postal') }}" name="zip"
                                                       id="billing:postcode" placeholder="{{ __('front.zip_postal') }}"
                                                       class="input-text validate-zip-international  required-entry" required
                                                       value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->zip : '' }}">

                                            </div>
                                            <div class="input-box">
                                                <label for="billing:telephone">{{ __('front.telephone') }}<em
                                                            class="required">*</em></label>

                                                <input type="text" name="phone"
                                                       title="{{ __('front.telephone') }}" placeholder="{{ __('front.telephone') }}"
                                                       class="input-text  required-entry" id="billing:telephone" required
                                                       value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : '' }}">

                                            </div>
                                        </li>
                                    </ul>

                                </fieldset>
                            </li>
                            <li class="">
                                <div class="row {{ $digital == 1 ? 'd-none' : '' }}">
                                    <div class="col-lg-12 mt-3">
                                        <input class="styled-checkbox" id="ship-diff-address"
                                               type="checkbox" value="value1">
                                        <label for="ship-diff-address"><span></span>{{ __('front.ship_to_different') }}</label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="step-title ship-diff-addres-area d-none">
                <span class="number">3</span>
                <h3 class="one_page_heading"> {{ __('front.shipping_information') }}</h3>
                <div id="checkout-step-billing" class="step a-item">
                    <fieldset class="group-select">
                        <ul class="">
                            <li id="billing-new-address-form">
                                <fieldset>
                                    <ul>
                                        <li class="fields">
                                            <div class="customer-name">
                                                <div class="input-box name-firstname">
                                                    <div class="input-box1">
                                                        <input type="text" id="shippingFull_name"
                                                               name="shipping_name" placeholder="{{ __('front.enter_your_name') }}"
                                                               title="{{ __('front.enter_your_name') }}" maxlength="255"
                                                               class="input-text required-entry"
                                                               value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : '' }}">
                                                        <input type="hidden" name="shipping_email" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="wide">
                                            <input type="text" title="{{ __('front.address') }}" name="shipping_address"
                                                   id="shipping_address"
                                                   placeholder="{{ __('front.address') }}" class="input-text  required-entry">

                                        </li>
                                        <li class="fields">
                                            <div class="input-box">
                                                <label for="shipping_city">{{ __('front.city') }}<em class="required">*</em></label>

                                                <input type="text" title="{{ __('front.city') }}" name="shipping_city" placeholder="{{ __('front.city') }}"
                                                       class="input-text input-city required-entry" id="shipping_city">

                                            </div>
                                            <div class="field">
                                                <label for="shipping:region_id">{{ __('front.country') }}<em class="required">*</em></label><br>
                                                <div class="input-box">
                                                    <select id="shipping:region_id" name="shipping_country"
                                                            title="{{ __('front.country') }}"
                                                            class="validate-select country-select required-entry" defaultvalue="1">
                                                        @include('includes.countries')
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="fields">
                                            <div class="input-box">
                                                <label for="shippingPostal_code">{{ __('front.zip_postal') }}<em class="required">*</em></label>

                                                <input type="text" title="{{ __('front.zip_postal') }}" name="shipping_zip"
                                                       id="shippingPostal_code" placeholder="{{ __('front.zip_postal') }}"
                                                       class="input-text validate-zip-international  required-entry">

                                            </div>
                                            <div class="input-box">
                                                <label for="shipingPhone_number">{{ __('front.telephone') }}<em
                                                            class="required">*</em></label>

                                                <input type="text" name="shipping_phone"
                                                       title="{{ __('front.telephone') }}" placeholder="{{ __('front.telephone') }}"
                                                       class="input-text  required-entry" id="shipingPhone_number">

                                            </div>
                                        </li>
                                    </ul>

                                </fieldset>
                            </li>
                        </ul>
                    </fieldset>
                </div>
            </div>


        </li>
    </ol>
</div>
