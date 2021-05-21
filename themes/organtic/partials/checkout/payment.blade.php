<div class="section-payment">
    <ol class="one-page-checkout" id="checkoutSteps3">
        <li id="opc-billing" class="section allow active">
            <div class="step-title">
                <h3 class="one_page_heading"> {{ __('front.shipping_information') }}</h3>
                <div id="checkout-step-payment" class="step a-item">
                    <div class="billing-info-area {{ $digital == 1 ? 'd-none' : '' }}">
                        <ul class="info-list">
                            <li>
                                <p id="shipping_user"></p>
                            </li>
                            <li>
                                <p id="shipping_location"></p>
                            </li>
                            <li>
                                <p id="shipping_phone"></p>
                            </li>
                            <li>
                                <p id="shipping_email"></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="step-title">
                <h3 class="one_page_heading"> {{ __('front.payment_method') }}</h3>
                <div id="checkout-step-payment" class="step a-item">
                    Payment Gateways here
                </div>
            </div>

        </li>
    </ol>
</div>