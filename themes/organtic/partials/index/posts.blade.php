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
                    <div class="post-date">
                        <time class="entry-date" datetime="2015-05-11T11:07:27+00:00">26 <span>June</span></time>
                    </div>
                    <ul class="post-meta">
                        <li><i class="fa fa-comments"></i><a href="#">{{ $post->views }}</a> </li>
                    </ul>
                    <h3><a href="blog-detail.html">{{mb_strlen($post->title,'utf-8') > 50 ? mb_substr($post->title,0,50,'utf-8')."...":$post->title}}</a></h3>
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