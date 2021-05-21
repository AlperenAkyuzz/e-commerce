<footer>
    <!-- BEGIN INFORMATIVE FOOTER -->
    <div class="footer-inner">
        @include('theme::widgets.newsletter')
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-column">
                            <h4>{{ __('front.fast-access') }}</h4>
                            <ul class="links">
                                @foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
                                    <li><a href="{{ url($data->slug) }}"
                                           title="{{ $data->title }}"><span>{{ $data->title }}</span></a></li>
                                @endforeach
                                @if($gs->is_faq == 1)
                                    <li><a href="{{ url('front.faq') }}"
                                           title="{{ __('front.faq') }}"><span>{{ __('front.faq') }}</span></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-column">
                            <h4>{{ __('front.contact-us') }}</h4>
                            <div class="contacts-info">
                                <address>
                                    <i class="add-icon"></i>{{ $ps->street }}<br>
                                    Türkiye<br>
                                </address>
                                <div class="phone-footer"><i class="phone-icon"></i>{{ $ps->phone }}</div>
                                <div class="email-footer"><i class="email-icon"></i><a
                                            href="mailto:{{ $ps->email }}">{{ $ps->email }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-column recent-post-widget">
                            <h4>{{ __('front.latest-posts') }}</h4>
                            <ul class="post-list">
                                @foreach (App\Models\Blog::orderBy('created_at', 'desc')->limit(3)->get() as $blog)
                                    <li>
                                        <div class="post">
                                            <div class="post-img">
                                                <img style="width: 73px; height: 59px;"
                                                     src="{{ asset('assets/images/blogs/'.$blog->photo) }}" alt="">
                                            </div>
                                            <div class="post-details">
                                                <a href="{{ route('front.blogshow',$blog->slug) }}">
                                                    <h4 class="post-title">
                                                        {{mb_strlen($blog->title,'utf-8') > 45 ? mb_substr($blog->title,0,45,'utf-8')." .." : $blog->title}}
                                                    </h4>
                                                </a>
                                                <p class="date">
                                                    {{ date('M d - Y',(strtotime($blog->created_at))) }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--container-->
    </div>
    <!--footer-inner-->

    <!--footer-middle-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="social">
                        <ul>
                            @if($socialsetting->f_status == 1)
                                <li class="fb"><a href="{{ $socialsetting->facebook }}"></a></li>
                            @endif
                            @if($socialsetting->t_status == 1)
                                <li class="tw"><a href="{{ $socialsetting->twitter }}"></a></li>
                            @endif
                            @if($socialsetting->g_status == 1)
                                <li class="googleplus"><a href="{{ $socialsetting->gplus }}"></a></li>
                            @endif
                            @if($socialsetting->l_status == 1)
                                <li class="linkedin"><a href="{{ $socialsetting->linkedin }}"></a></li>
                            @endif
                            {{--<li class="youtube"><a href="#"></a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 coppyright"> © 2021 Parionsoft. All Rights Reserved.</div>
                <div class="col-xs-12 col-sm-4">
                    <div class="payment-accept"><img src="{{ asset('themes/organtic/assets/img/payment-1.png') }}"
                                                     alt=""> <img
                                src="{{ asset('themes/organtic/assets/img/payment-2.png') }}" alt=""> <img
                                src="{{ asset('themes/organtic/assets/img/payment-3.png') }}" alt=""> <img
                                src="{{ asset('themes/organtic/assets/img/payment-4.png') }}" alt=""></div>
                </div>
            </div>
        </div>
    </div>
    <!--footer-bottom-->
    <!-- BEGIN SIMPLE FOOTER -->
</footer>