
<!DOCTYPE html>

@yield('html')
<head>
    
    @include('partials.meta')
    {!! $pageContent->yoast_head !!}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="page-wrap dev-landing dev-landing--level1">
       
        @if ($pageContent->acf->banner->banner_background_type === 'none')
            @include('partials.header')
            @include('partials.header-mobile')
        @else
            @include('partials.header-ghost')
        @endif  

        <div class="landing__banner">
            <div
                data-component="banner" 
                data-prop-banner="{{json_encode($pageContent->acf->banner)}}"
            ></div>
        </div>

        <main id="main">
            @foreach($pageContent->acf->dev_landing_builder as $section) 
                @if($section->acf_fc_layout == "second_level_navigation")
                    <div
                        data-component="second-level-nav" 
                        data-prop-heading="{{$section->heading}}"
                        data-prop-blocks="{{json_encode($section->navigation_blocks)}}"
                    ></div>
                @endif
                @if($section->acf_fc_layout == "tabs")
                    <div class="container container--mk4">
                        <div class="row">
                            <div class="col-sm-12">  
                                <div 
                                    data-component="tabs" 
                                    data-prop-heading="{{$section->heading}}"
                                    data-prop-description="{{$section->description}}"
                                    data-prop-tabs="{{json_encode($section->tab)}}"
                                ></div>
                            </div>
                        </div>
                    </div>                                
                @endif
            @endforeach
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