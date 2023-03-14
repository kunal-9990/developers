
<!DOCTYPE html>
@yield('html')
<head>
    @include('partials.meta')
    {!! $pageContent->yoast_head !!}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
  	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KX6JHHN"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
      
    <div class="page-wrap">
       
        <div class="faq">

            @if ($pageContent->acf->banner->banner_background_type === 'none')
                @include('partials.header')
                @include('partials.header-mobile')
            @else
                @include('partials.header-ghost')
            @endif

            <div class="faq__banner">
                <div
                    data-component="banner" 
                    data-prop-banner="{{htmlspecialchars(json_encode($pageContent->acf->banner))}}"
                ></div>
            </div>

            <div class="container container--mk4 breadcrumb-container">
                <div class="row">
                    <div class="col-sm-12">
                        {{ Breadcrumbs::render('faq') }}
                    </div>
                </div>
            </div> 
            <main id="main">
                <div class="container container--mk4">
                    <div class="row">
                        <div class="col-sm-12">
                           <div 
                                data-component="faq" 
                                data-prop-faqs="{{htmlspecialchars(json_encode($pageContent->acf->faq))}}" 
                            ></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div data-component="region-lightbox"
            data-prop-open={{json_encode(session('openRegionLightbox'))}}
            data-prop-redirect={{str_replace('/'.app('request')->route()->parameters['region'].'/', '/'.Cookie::get('region').'/', Request::url())}}
    ></div>
        @include('partials.cookie-consent')
        @include('partials.footer')
        @include('partials.footer-includes')

</body>
</html>
