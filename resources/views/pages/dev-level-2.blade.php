
<!DOCTYPE html>

@yield('html')
<head>
    
    @include('partials.meta')
    {!! $pageContent->yoast_head !!}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="page-wrap dev-landing dev-landing--level2">
       


        <main id="main">
<h1>Dev level 2</h1>


        </main>
    </div>

    @if(!Cookie::get('modalDismissed'))
    <div data-component="region-lightbox"
            data-prop-open={{json_encode(session('openRegionLightbox'))}}
            data-prop-redirect={{str_replace('/'.app('request')->route()->parameters['region'].'/', '/'.session('requestRegion').'/', Request::url())}}
    ></div>
    @endif

        @include('partials.cookie-consent')
        @include('partials.footer')
        @include('partials.footer-includes')
        
</body>
</html>