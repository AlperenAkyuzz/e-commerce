@php

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    {
      $link = "https";
    }
    else
    {
      $link = "http";

      // Here append the common URL characters.
      $link .= "://";

      // Append the host(domain name, ip) to the URL.
      $link .= $_SERVER['HTTP_HOST'];

      // Append the requested resource location to the URL
      $link .= $_SERVER['REQUEST_URI'];
    }

@endphp

<aside class="col-left sidebar col-sm-3 col-xs-12 wow bounceInUp animated animated"
       style="visibility: visible;">
    <div class="block block-account">
        <div class="block-title"> {{ __('auth.my-account') }}</div>
        <div class="block-content">
            <ul>
                <li class="{{ $link == route('user-dashboard') ? 'current':'' }}">
                    <a href="{{ route('user-dashboard') }}">{{ __('auth.orders') }}</a>
                </li>
                @if(Auth::user()->IsVendor())
                    <li><a href="{{ route('vendor-dashboard') }}"><span> Mağaza Yönetimi</span></a></li>
                @endif
                <li class="{{ $link == route('user-wishlists') ? 'current':'' }}">
                    <a href="{{ route('user-wishlists') }}">{{ __('auth.wishlist') }}</a>
                </li>
                <li class="{{ $link == route('user-favorites') ? 'current':'' }}">
                    <a href="{{ route('user-favorites') }}">{{ __('auth.user-favorites') }}</a>
                </li>
                <li class="{{ $link == route('user-dmessage-index') ? 'current':'' }}">
                    <a href="{{ route('user-dmessage-index') }}">{{ __('auth.disputes') }}</a>
                </li>
                <li class="{{ $link == route('user-profile') ? 'current':'' }}">
                    <a href="{{ route('user-profile') }}">{{ __('auth.profile-edit') }}</a>
                </li>
                <li class="{{ $link == route('user-reset') ? 'current':'' }}">
                    <a href="{{ route('user-reset') }}">{{ __('auth.reset-password') }}</a>
                </li>
                <li class="{{ $link == route('user-logout') ? 'current':'' }}">
                    <a href="{{ route('user-logout') }}">{{ __('auth.Logout') }}</a>
                </li>
            </ul>
        </div>
        <!--block-content-->
    </div>
    <!--block block-account-->
</aside>
<!--col-right sidebar col-sm-3 wow bounceInUp animated-->