@php
        $settings = \App\Models\Generalsetting::first();
@endphp
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('theme::title', $settings->title) | {{ $settings->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Default Description">
    <meta name="keywords" content="fashion, store, E-commerce">
    <meta name="robots" content="*">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="#" type="image/x-icon">

    <!-- CSS Style -->
    <!-- Theme Styles -->
    <link rel="stylesheet" href="{{ asset(mix('themes/organtic/assets/css/app.css')) }}" media="all" />
    <link rel="stylesheet" href="{{ asset('themes/organtic/assets/css/font-awesome.css') }}" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />


    <!-- Toastr -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    @yield('theme::styles')

    <link rel="stylesheet" href="{{ asset('assets/front/css/gs-custom.css') }}" media="all" />
{{--    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700" rel="stylesheet">--}}
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600,800,400' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i,900" rel="stylesheet">

   
</head>
<body>
    <div id="page">

        @if($gs->is_popup== 1)
            @if(isset($visited))
                @include('theme::load.popup')
            @endif
        @endif

        @include('theme::layouts.header', ['header_title' => 'test'] )

        @yield('theme::content')

        @include('theme::layouts.footer')


    </div>

    @include('theme::layouts.mobile-menu')

    <!-- Theme Scripts -->

    {{-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> --}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>--}}

    <script src="{{ asset('themes/organtic/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset(mix('themes/organtic/assets/js/app.js')) }}"></script>

    @yield('theme::scripts')

    <script type="text/javascript">
        window.translations = {!! Cache::get('translations') !!};
        var mainurl = "{{url('/')}}";
    </script>

    <script src="{{ asset('assets/front/js/gs-custom.js')}}"></script>

    
</body>
</html>