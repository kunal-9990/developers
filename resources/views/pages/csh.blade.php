
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
       
        <div class="csh">

            @if ($pageContent->acf->banner->banner_background_type === 'none')
                @include('partials.header')
                @include('partials.header-mobile')
            @else
                @include('partials.header-ghost')
            @endif

            <div class="csh__banner">
                <div
                    data-component="banner" 
                    data-prop-banner="{{htmlspecialchars(json_encode($pageContent->acf->banner))}}"
                ></div>
            </div>
            <div class="container container--mk4 breadcrumb-container">
                <div class="row">
                    <div class="col-sm-12">
                        {{ Breadcrumbs::render('csh') }}
                    </div>
                </div>
            </div> 
            
            <main id="main" class="mk4">
                                 
                @if(isset($pageContent->acf->intro_text))
                <div class="container container--mk4 landing__block">
                    <div class="row">
                        <div class="col-sm-12">
                            <div>{!! $pageContent->acf->intro_text !!}</div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="container container--mk4">
                    <div class="row">
                        <div class="col-sm-12">
                           <div 
                                data-component="csh" 
                                data-props="{{htmlspecialchars(json_encode($pageContent->acf->group))}}" 
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
