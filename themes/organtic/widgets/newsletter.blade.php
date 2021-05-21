<div class="newsletter-row" style="background:url({{ asset('themes/organtic/assets/img/shipping-v2.jpg') }} no-repeat top left; background-size: cover;">
    <div class="container">
        <div class="row">
            <!-- newsletter -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col1">
                <div class="newsletter-wrap">
                    <div class="newsletter-response"></div>
                    <h5>{{ __('front.newsletter') }}</h5>
                    <h4>{{ __('front.newsletter_desc') }}</h4>
                    <form action="#" method="post" id="newsletter-validate-detail1">
                        <div id="container_form_news">
                            <div id="container_form_news2">
                                <input type="text" name="email" id="newsletter1" title="{{ __('front.newsletter_desc') }}" class="input-text required-entry validate-email" placeholder="{{ __('front.enter_your_email') }}">
                                <button type="submit" title="Subscribe" class="button subscribe"><span>{{ __('front.newsletter_button') }}</span></button>
                            </div>
                            <!--container_form_news2-->
                        </div>
                        <!--container_form_news-->
                    </form>
                </div>
                <!--newsletter-wrap-->
            </div>
        </div>
    </div>
    <!--footer-column-last-->
</div>