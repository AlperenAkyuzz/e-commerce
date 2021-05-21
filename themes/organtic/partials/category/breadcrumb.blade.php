<div class="page-heading" style="background-image: url({{ asset('themes/organtic/assets/img/category-bg.jpg') }}">
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>

                        <li>
                            <a href="{{route('front.index')}}">{{ $langg->lang17 }} </a>
                        </li>
                        @if (!empty($cat))
                            <li>
                                <a href="{{route('front.category', $cat->slug)}}">{{ $cat->name }}</a>
                            </li>
                        @endif
                        @if (!empty($subcat))
                            <li>
                                <a href="{{route('front.category', [$cat->slug, $subcat->slug])}}">{{ $subcat->name }}</a>
                            </li>
                        @endif
                        @if (!empty($childcat))
                            <li>
                                <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}">{{ $childcat->name }}</a>
                            </li>
                        @endif
                        @if (empty($childcat) && empty($subcat) && empty($cat))
                            <li>
                                <a href="{{route('front.category')}}">{{ $langg->lang36 }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!--col-xs-12-->
            </div>
            <!--row-->
        </div>
        <!--container-->
    </div>
    <div class="page-title">
        <h2>{{ $catalogName }}</h2>
    </div>
</div>