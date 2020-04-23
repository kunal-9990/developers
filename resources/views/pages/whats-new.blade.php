
<!DOCTYPE html>
@yield('html')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">
    
    {{-- FontAwesome icons --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/brands.css" integrity="sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
</head>
<body>
    <div class="whats-new">
        {{ csrf_token() }}
        @php
        // dd($pageContent);
        if(!isset($noHeader)){
            $noHeader = false;
        }
        
        @endphp
        @if(!$noHeader)
        @include('partials.header')
        @include('partials.header-mobile')
        @endif

        <div 
            data-component="announcement"
            data-props='{"title":"{{$pageContent->acf->announcement->post_title}}", "description":"{{$pageContent->acf->announcement->post_content}}"}'
        ></div>

        <div 
            data-component="banner"
            data-props='{"background":"{{$pageContent->acf->title_background_image->url}}","product":"{{$pageContent->acf->product." ".$pageContent->acf->version}}", "strapline":"{{$pageContent->acf->strapline}}"}'
        ></div>



        <main id="main">
            <div class="whats-new">
                <div class="whats-new__intro">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4 in-this-article">
                                    <span>In this article</span>
                                    @foreach($pageContent->acf->features as $feature)
                                    <ul><li>
                                        <a href="#{{ trim(preg_replace('/\s+/', '-', $feature->title)) }}">
                                        {{$feature->title}}
                                    </a>
                                    </li></ul>
                                    @endforeach

                                    <div data-component="social-share"></div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="iframe-video-wrapper">
                                        <iframe  
                                            src="{{$pageContent->acf->featured_video}}" 
                                            class="yt-video-iframe" 
                                            frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="iframe-video-wrapper">
                                    <iframe  
                                        src="{{$pageContent->acf->featured_video}}" 
                                        class="yt-video-iframe" 
                                        frameborder="0"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="docs__container">
                            <div>
                                @foreach($pageContent->acf->features as $feature)
                                @php
                                    $featureVotes = (isset($voteData[$feature->title])) ? $voteData[$feature->title] : 0;
                                @endphp
                                    <div 
                                        data-component="feature" 
                                        data-props='{
                                            "title": "{{$feature->title}}", 
                                            "description": {{htmlspecialchars(json_encode($feature->description))}},
                                            "showVoter": "{{$feature->allow_voting}}"
                                        }'
                                        data-n-prop-votes={{$featureVotes}}
                                    ></div>
                                @endforeach
                            </div>
                            @include('partials.filter-msg', [
                                'exclusiveTo' =>  isset($exclusiveTo) ? $exclusiveTo : false,
                            ])
                        </div>
                    </div>
                </div>
            </div>

            {{-- back to top button --}}
            @include('partials.back-to-top')

            {{-- modal overlay for images in content --}}
            @include('partials.image-modal')

            {{-- modal overlay for email subscription and pdf download --}}
            @include('partials.download-pdf')
        </main>

        <div data-component="survey"></div>

        @include('partials.cookie-consent')
        @include('partials.footer')
    </div>
        @if(Route::current()->parameters()["lang"] == "en")
            <!-- begin olark code -->
            <script type="text/javascript" async>
                ;(function(o,l,a,r,k,y){if(o.olark)return; r="script";y=l.createElement(r);r=l.getElementsByTagName(r)[0]; y.async=1;y.src="//"+a;r.parentNode.insertBefore(y,r); y=o.olark=function(){k.s.push(arguments);k.t.push(+new Date)}; y.extend=function(i,j){y("extend",i,j)}; y.identify=function(i){y("identify",k.i=i)}; y.configure=function(i,j){y("configure",i,j);k.c[i]=j}; k=y._={s:[],t:[+new Date],c:{},l:a}; })(window,document,"static.olark.com/jsclient/loader.js");
            /* custom configuration goes here (www.olark.com/documentation) */
            olark.identify('4439-775-10-8635');
            </script>
            <!-- end olark code -->
        @endif
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
        
        <script src="{{ mix('/js/mk2/app.js') }}"></script>
        <script src="{{ mix('/js/mk4/app.js') }}"></script>
</body>
</html>