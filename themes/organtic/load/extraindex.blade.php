@if($ps->best == 1)
    <!-- Phone and Accessories Area Start -->
    <section class="wow bounceInUp animated">
        <div class="best-pro slider-items-products container">
            <div class="new_title">
                <img src="{{ asset('themes/organtic/assets/img/best-seller-icon.png') }}" alt="en çok satılanlar">
                <h2>{{ __('front.best_sellers') }}</h2>
            </div>
            <div id="best-seller" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 products-grid">
                    @foreach($best_products as $product)
                        @include('theme::includes.product.home-product')
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 remove-padding d-none d-lg-block">
                <div class="aside">
                    <a class="banner-effect mb-10" href="{{ $ps->best_seller_banner_link }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner)}}" alt="">
                    </a>
                    <a class="banner-effect" href="{{ $ps->best_seller_banner_link1 }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner1)}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Phone and Accessories Area start-->
@endif

@if($ps->flash_deal == 1)
    <!-- Electronics Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flash-deals">
                        <div class="flas-deal-slider">

                            @foreach($discount_products as $prod)
                                @include('includes.product.flash-product')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Electronics Area start-->
@endif

@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section large-banner mobile-hide">
        <div class="container">
            @foreach($large_banners->chunk(1) as $chunk)
                <div class="row">
                    @foreach($chunk as $img)
                        <div class="col-lg-12 remove-padding">
                            <div class="img">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif

@if($ps->top_rated == 1)
    <!-- Electronics Area Start -->
    <section class=" wow bounceInUp animated">
        <div class="best-pro slider-items-products container">
            <div class="new_title">
                <img src="{{ asset('themes/organtic/assets/img/top-rated-icon.png') }}" alt="en çok satılanlar">
                <h2>{{ __('front.top_trending') }}</h2>
            </div>
            <div id="best-seller" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 products-grid">
                    @foreach($top_products as $product)
                        @include('theme::includes.product.home-product')
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 remove-padding d-none d-lg-block">
                <div class="aside">
                    <a class="banner-effect mb-10" href="{{ $ps->best_seller_banner_link }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner)}}" alt="">
                    </a>
                    <a class="banner-effect" href="{{ $ps->best_seller_banner_link1 }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner1)}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Electronics Area start-->
@endif

@if($ps->bottom_small == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section mobile-banner-small">
        <div class="container">
            @foreach($bottom_small_banners->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $img)
                        <div class="col-lg-4 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}" target="_blank">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif

@if($ps->big == 1)
    <!-- Clothing and Apparel Area Start -->
    <section class="wow bounceInUp animated">
        <div class="best-pro slider-items-products container">
            <div class="new_title">
                <img src="{{ asset('themes/organtic/assets/img/best-seller-icon.png') }}" alt="en çok satılanlar">
                <h2>{{ __('front.big_save') }}</h2>
            </div>
            <div id="best-seller" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 products-grid">
                    @foreach($big_products as $product)
                        @include('theme::includes.product.home-product')
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 remove-padding d-none d-lg-block">
                <div class="aside">
                    <a class="banner-effect mb-10" href="{{ $ps->best_seller_banner_link }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner)}}" alt="">
                    </a>
                    <a class="banner-effect" href="{{ $ps->best_seller_banner_link1 }}">
                        <img src="{{asset('assets/images/'.$ps->best_seller_banner1)}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Clothing and Apparel Area start-->
@endif

@if($ps->hot_sale == 1)
    <!-- hot-and-new-item Area Start -->
    <section class="hot-and-new-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="accessories-slider">
                        <div class="slide-item">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="categori">
                                        <div class="section-top">
                                            <h2 class="section-title">
                                                {{ $langg->lang30 }}
                                            </h2>
                                        </div>
                                        <div class="hot-and-new-item-slider">
                                            @foreach($hot_products->chunk(3) as $chunk)
                                                <div class="item-slide">
                                                    <ul class="item-list">
                                                        @foreach($chunk as $prod)
                                                            @include('includes.product.list-product')
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="categori">
                                        <div class="section-top">
                                            <h2 class="section-title">
                                                {{ $langg->lang31 }}
                                            </h2>
                                        </div>

                                        <div class="hot-and-new-item-slider">

                                            @foreach($latest_products->chunk(3) as $chunk)
                                                <div class="item-slide">
                                                    <ul class="item-list">
                                                        @foreach($chunk as $prod)
                                                            @include('includes.product.list-product')
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="categori">
                                        <div class="section-top">
                                            <h2 class="section-title">
                                                {{ $langg->lang32 }}
                                            </h2>
                                        </div>


                                        <div class="hot-and-new-item-slider">

                                            @foreach($trending_products->chunk(3) as $chunk)
                                                <div class="item-slide">
                                                    <ul class="item-list">
                                                        @foreach($chunk as $prod)
                                                            @include('includes.product.list-product')
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="categori">
                                        <div class="section-top">
                                            <h2 class="section-title">
                                                {{ $langg->lang33 }}
                                            </h2>
                                        </div>

                                        <div class="hot-and-new-item-slider">

                                            @foreach($sale_products->chunk(3) as $chunk)
                                                <div class="item-slide">
                                                    <ul class="item-list">
                                                        @foreach($chunk as $prod)
                                                            @include('includes.product.list-product')
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Clothing and Apparel Area start-->
@endif

@if($ps->review_blog == 1)
    <!-- Blog Area Start -->
    <section class="blog-area">
        <div class="container">
            <!-- Home Lastest Blog Block -->
            <div class="latest-blog wow bounceInUp animated animated container">
                <!--exclude For version 6 -->
                <div class="new_title">
                    <img src="{{ asset('themes/organtic/assets/img/blog-icon.png') }}" alt="icon">
                    <h2>{{ __('front.latest-posts') }}</h2>
                </div>
                <!--For version 1,2,3,4,5,6,8 -->
                <div class="row">
                    @foreach(\App\Models\Blog::getBlogs(3) as $post)
                        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4 blog-post">
                            <div class="blog_inner">
                                <div class="blog-img"> <a href="{{ route('front.blogshow', $post->slug) }}"> <img src="{{ asset('assets/images/blogs/'.$post->photo) }}" alt="{{ $post->title }}"> </a>
                                    <div class="mask"></div>
                                </div>
                                <!--blog-img-->
                                <div class="blog-info">
                                    <ul class="post-meta">
                                        <li><i class="fa fa-eye"></i>{{ __('front.count-views', ['view' => $post->views ]) }} </li>
                                    </ul>
                                    <h3><a href="{{ route('front.blogshow',$post->slug) }}">{{mb_strlen($post->title,'utf-8') > 50 ? mb_substr($post->title,0,50,'utf-8')."...":$post->title}}</a></h3>
                                    <p>{{substr(strip_tags($post->details),0,120)}}...</p>
                                    <a class="info" href="{{ route('front.blogshow', $post->slug) }}">{{ __('front.read-more') }}</a>
                                </div>
                            </div>
                            <!--blog_inner-->
                        </div>
                    @endforeach

                </div>
                <!--END For version 1,2,3,4,5,6,8 -->
                <!--exclude For version 6 -->
                <!--container-->
            </div>
        </div>
    </section>
    <!-- Blog Area start-->
@endif

@if($ps->partners == 1)

    <!-- Partners Area Start -->
    <section class="wow bounceInUp animated">
        <div class="best-pro slider-items-products container">
            <div class="logo-brand">
                <div class="slider-items-products">
                    <div id="brand-slider" class="product-flexslider brand-slider hidden-buttons">
                        <div class="slider-items slider-width-col6">
                            @foreach($partners as $data)
                                <!-- Item -->
                                <div class="item">
                                    <div class="logo-item"><a href="{{ $data->link }}"><img src="{{asset('assets/images/partner/'.$data->photo)}}" alt=""></a>
                                    </div>
                                </div>
                                <!-- End Item -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Partners Area Start -->
@endif

@if($ps->service == 1)

    {{-- Info Area Start --}}
    <section class="info-area">
        <div class="container">

            @foreach($services->chunk(4) as $chunk)

                <div class="row">

                    <div class="col-lg-12 p-0">
                        <div class="info-big-box">
                            <div class="row">
                                @foreach($chunk as $service)
                                    <div class="col-6 col-xl-3 p-0">
                                        <div class="info-box">
                                            <div class="icon">
                                                <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                                            </div>
                                            <div class="info">
                                                <div class="details">
                                                    <h4 class="title">{{ $service->title }}</h4>
                                                    <p class="text">
                                                        {!! $service->details !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            @endforeach

        </div>
    </section>
    {{-- Info Area End  --}}

@endif

