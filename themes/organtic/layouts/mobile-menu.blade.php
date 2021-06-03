<div id="mobile-menu">
    <ul>
        <li>
            <div class="mm-search">
                <form id="search1" name="search">
                    <div class="input-group">

                        <input type="text" class="form-control simple" placeholder="Search ..." name="srch-term"
                            id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li>
            <div class="home"><a href="{{ route('front.index') }}">{{ __('front.home') }}</a> </div>
        </li>
        @foreach( $categories->where('is_featured', 1) as $category)
        <li><a href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a>
            @if(count($category->subs) > 0)
            <ul>
                @foreach($category->subs()->whereStatus(1)->get() as $subcat)
                <li>
                    <a href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{ $subcat->name }}</a>
                    @if(count($subcat->childs) > 0)
                        <ul>
                        @foreach($subcat->childs()->whereStatus(1)->get() as $childcat)
                                <li><a href="{{ route('front.childcat',['slug1' => $category->slug, 'slug2' => $subcat->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
                        @endforeach
                        </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
    <div class="top-links">
        <ul class="links">
            <li><a title="{{ __('auth.my-account') }}" href="{{ route('user-dashboard') }}">@if(Auth::guard('web')->check()) {{ __('auth.my-account') }} @else {{ __('auth.Login') }} @endif</a> </li>
            <li><a title="{{ __('front.wishlist') }}" href="{{ route('user-wishlists') }}">{{ __('front.wishlist') }}</a> </li>
            @if(Auth::guard('web')->check())
                <li class="last"><a title="{{ __('auth.Logout') }}" href="{{ route('user-logout') }}">{{ __('auth.Logout') }}</a> </li>
            @endif
        </ul>
    </div>
</div>
