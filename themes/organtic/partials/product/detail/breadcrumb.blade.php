
<div class="page-heading" style="background-image: url({{ asset('themes/organtic/assets/img/category-bg.jpg') }}">
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"> <a href="{{ route('front.index') }}" title="{{ __('front.home') }}">{{ __('front.home') }}</a> <span>&rsaquo; </span>
                        </li>
                        <li class="category1601"> <strong>{{ $product->category->name }}</strong> </li>
                    </ul>
                </div>
                <!--col-xs-12-->
            </div>
            <!--row-->
        </div>
        <!--container-->
    </div>
    <div class="page-title">
        <h2>{{ $product->category->name }}</h2>
    </div>
</div>
