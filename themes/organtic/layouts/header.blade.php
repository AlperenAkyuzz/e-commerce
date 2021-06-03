<header>
    <div class="header-banner"
         style="background:url({{ asset('themes/organtic/assets/img/h48.jpg') }}) no-repeat top left;">
        <div class="assetBlock">
            <div id="slideshow">
                <p> <span>{{ $gs->free_cargo_price }}₺</span> üzeri alışverişlerde <span>{!! __('front.free_cargo') !!}</span> </p>
                <p> <span>{{ $gs->free_cargo_price }}₺</span> üzeri alışverişlerde <span>{!! __('front.free_cargo') !!}</span> </p>
            </div>
        </div>
    </div>

    <div id="header">
        <div class="container">
            <div class="header-container row">
                <div class="logo">
                    <a href="{{ route('front.index') }}" title="index">
                        <div><img src="{{ asset('themes/organtic/assets/img/logo_main.png') }}" alt="logo"></div>
                    </a>
                </div>
                <div class="fl-nav-menu">
                    <nav>
                        <div class="mm-toggle-wrap">
                            <div class="mm-toggle"><i class="icon-align-justify"></i><span class="mm-label">Menu</span>
                            </div>
                        </div>
                        <div class="header-search-area">
                            @livewire('search-products')
                        </div>
                    </nav>
                </div>

                <!--row-->

                <div class="fl-header-right">
                    <div class="fl-links">
                        <div class="no-js"><a title="Company" class="clicker"></a>
                            <div class="fl-nav-links">
                                <ul class="links">
                                    <li><a title="{{ __('auth.my-account') }}" href="{{ route('user-dashboard') }}">@if(Auth::guard('web')->check()) {{ __('auth.my-account') }} @else {{ __('auth.Login') }} @endif</a> </li>
                                    <li><a title="{{ __('front.wishlist') }}" href="{{ route('user-wishlists') }}">{{ __('front.wishlist') }}</a> </li>
                                    @if(Auth::guard('web')->check())
                                        <li class="last"><a title="{{ __('auth.Logout') }}" href="{{ route('user-logout') }}">{{ __('auth.Logout') }}</a> </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="fl-cart-contain">
                        <div class="mini-cart">
                            <div class="basket"><a href="{{ route('front.cart') }}"><span
                                            class="cart-count"> {{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }} </span></a>
                            </div>
                            <div class="cart-load">
                                @include('theme::load.cart')
                            </div>
                        </div>
                    </div>
                    <!--mini-cart-->
                    <!--links-->
                </div>
            </div>
        </div>
    </div>

    <div id="header header-categories">
        <div class="container">
            <div class="header-container row">
                <div class="fl-nav-menu">
                    <nav>
                        <div class="nav-inner">
                            <!-- BEGIN NAV -->
                            <ul id="nav" class="hidden-xs">

                                @foreach( $categories->where('is_featured', 1) as $category)
                                    <li class="{{count($category->subs) > 0 ? 'mega-menu':''}}"><a class="level-top"
                                                                                                   href="{{ route('front.category',$category->slug) }}"><span>{{ $category->name }}</span></a>
                                        <div class="level0-wrapper dropdown-6col">
                                            <div class="container">
                                                <div class="level0-wrapper2">
                                                    <div class="@if($category->photo) col-1 @else col-full @endif">
                                                        <div class="nav-block nav-block-center">
                                                            <!--mega menu-->
                                                            <ul class="level0">
                                                                @if(count($category->subs) > 0)
                                                                    @foreach($category->subs()->whereStatus(1)->get() as $subcat)
                                                                        <li class="level3 nav-6-1 parent item">
                                                                            <a href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">
                                                                                <span>{{$subcat->name}}</span>
                                                                            </a>
                                                                            <!--sub sub category-->
                                                                            @if(count($subcat->childs) > 0)
                                                                                @foreach($subcat->childs()->whereStatus(1)->get() as $childcat)
                                                                                    <ul class="level1">
                                                                                        <li class="level2 nav-6-1-1">
                                                                                            <a href="{{ route('front.childcat',['slug1' => $category->slug, 'slug2' => $subcat->slug, 'slug3' => $childcat->slug]) }}">
                                                                                                <span>{{$childcat->name}}</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                            @endforeach
                                                                        @endif

                                                                        <!--level1-->
                                                                            <!--sub sub category-->
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <!--level0-->
                                                        </div>
                                                        <!--nav-block nav-block-center-->
                                                    </div>
                                                    <!--col-1-->
                                                    @if($category->photo)
                                                        <div class="col-2">
                                                            <div class="menu_image"><a title=""
                                                                                       href="{{ route('front.category',$category->slug) }}"><img
                                                                            alt="menu_image"
                                                                            src="{{ asset('assets/images/categories/'.$category->photo) }}"
                                                                            width="315" height="285"></a>
                                                            </div>
                                                        </div>
                                                @endif
                                                <!--col-2-->
                                                </div>
                                                <!--level0-wrapper2-->
                                            </div>
                                            <!--container-->
                                        </div>
                                        <!--level0-wrapper dropdown-6col-->
                                        <!--mega menu-->
                                    </li>
                                @endforeach
                                @foreach(DB::table('pages')->where('header','=',1)->get() as $data)
                                    <li class="mega-menu"><a class="level-top" href="{{ url($data->slug) }}"><span>{{ $data->title }}</span></a></li>
                                @endforeach

                                {{--<li class="level0 parent drop-menu"><a href="#"><span>Pages</span> </a>
                                    <!--sub sub category-->
                                    <ul class="level1">
                                        <li class="level1 first"><a href="grid.html"><span>Product Grid</span></a></li>
                                        <li class="level1 nav-10-2"><a href="list.html"> <span>Product List</span> </a>
                                        </li>
                                        <li class="level1 nav-10-3"><a href="product-detail.html"> <span>Product
                                                    Detail</span> </a></li>
                                        <li class="level1 nav-10-4"><a href="shopping-cart.html"> <span>Cart
                                                    Page</span> </a></li>
                                        <li class="level1 first parent"><a
                                                    href="checkout.html"><span>Checkout</span></a>
                                            <!--sub sub category-->
                                            <ul class="level2 right-sub">
                                                <li class="level2 nav-2-1-1 first"><a
                                                            href="checkout-method.html"><span>Method</span></a></li>
                                                <li class="level2 nav-2-1-5 last"><a
                                                            href="checkout-billing-info.html"><span>Billing Info</span></a>
                                                </li>
                                            </ul>
                                            <!--sub sub category-->
                                        </li>
                                        <li class="level1 nav-10-4"><a href="wishlist.html"> <span>Wishlist</span> </a>
                                        </li>
                                        <li class="level1"><a href="dashboard.html"> <span>Dashboard</span> </a></li>
                                        <li class="level1"><a href="multiple-addresses.html"> <span>Multiple
                                                    Addresses</span> </a></li>
                                        <li class="level1"><a href="about-us.html"> <span>About us</span> </a></li>
                                        <li class="level1 first parent"><a href="blog.html"><span>Blog</span></a>
                                            <!--sub sub category-->
                                            <ul class="level2 right-sub">
                                                <li class="level2 nav-2-1-1 first"><a href="blog-detail.html"><span>Blog
                                                            Detail</span></a></li>
                                            </ul>
                                            <!--sub sub category-->
                                        </li>
                                        <li class="level1"><a href="contact-us.html"><span>Contact us</span></a></li>
                                        <li class="level1"><a href="404error.html"><span>404 Error Page</span></a></li>
                                        <li class="level1"><a href="login.html"><span>Login Page</span></a></li>
                                        <li class="level1"><a href="quickview.html"><span>Quick View</span></a></li>
                                        <li class="level1"><a href="newsletter.html"><span>Newsletter</span></a></li>
                                    </ul>
                                </li>--}}
                            </ul>
                            <!--nav-->
                        </div>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</header>
