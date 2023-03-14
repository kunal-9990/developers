@php
    // dd($pageContent->acf->hide_olark_chat);

    $title = $pageContent->acf->product . " " . $pageContent->acf->version . " - What's New";
@endphp
<!DOCTYPE html>
@yield('html')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   

    @include('partials.meta', [
        'canonical' => url('/'),
        'url' => url('/'),
        'title' => $title, 
        'og_description' => $title, 
        'canonical' => $title, 
        'doNotTranslate' => isset($doNotTranslate) ? $doNotTranslate : false,
        'hideOlark' => isset($pageContent->acf->hide_olark_chat) ?$pageContent->acf->hide_olark_chat : false
    ])
    {!! $pageContent->yoast_head !!}

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">
    {{-- FontAwesome icons --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/brands.css" integrity="sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
</head>
<body>
  	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KX6JHHN"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
      
    <div class="page-wrap">
    <div class="whats-new">
        @php
        // dd($pageContent);
        if(!isset($noHeader)){
            $noHeader = false;
        }
        @endphp
        @if(!$noHeader)
            @if($pageContent->acf->use_alternate_header == "desktop-header")
                @include('partials.header-desktop', ['logo' => $pageContent->acf->alternate_header_product_logo, "link" => isset($pageContent->acf->alternate_header_product_logo_link) ? $pageContent->acf->alternate_header_product_logo_link : "" ])
                @include('partials.header-mobile-desktop', ['logo' => $pageContent->acf->alternate_header_product_logo, "link" => isset($pageContent->acf->alternate_header_product_logo_link) ? $pageContent->acf->alternate_header_product_logo_link : "" ])       
            @else
                @include('partials.header')
                @include('partials.header-mobile')
            @endif     
        @endif

        @if ($pageContent->acf->announcement)
        <div 
            data-component="announcement"
            data-props="{{htmlspecialchars(json_encode($pageContent->acf->announcement))}}"
        ></div>
        @endif

        <div 
            data-component="whats-new-banner"
            data-props='{
                "background":"{{ !empty($pageContent->acf->title_background_image) ? $pageContent->acf->title_background_image->url : null }}",
                "product":"{{$pageContent->acf->product}}", 
                "version":"{{$pageContent->acf->version}}",
                "strapline":"{{$pageContent->acf->strapline}}"
            }'
        ></div>
        <div class="relative">
            <div 
                data-component="social-share"
                data-prop-message="{{ isset($pageContent->acf->social_message) ? $pageContent->acf->social_message : 'Check out this page from CaseWare!' }}"
            ></div>
        </div>
        <main id="main">
            <div class="whats-new">
                <div class="whats-new__intro">
                    <div class="container container--mk4">
                        <div class="row">
                            <div class="col-sm-12">
                            @if($pageContent->acf->featured_video !== "" || !empty($pageContent->acf->featured_video_thumbnail))
                                <div class="col-sm-4 ita">
                            @else 
                                <div class="col-sm-12 ita">
                            @endif
                                    <span>In this article</span>
                                    @foreach($pageContent->acf->features as $feature)
                                    <ul><li>
                                        <a href="#{{ trim(preg_replace('/\s+/', '-', $feature->title)) }}">
                                        {{$feature->title}}
                                    </a>
                                    </li></ul>
                                    @endforeach
                                </div>
                                <div class="col-sm-8" style="padding: 0">
                                    @if($pageContent->acf->featured_video !== "" || !empty($pageContent->acf->featured_video_thumbnail))
                                        <div 
                                            data-component="embedded-video"
                                            data-prop-thumbnail="{{ !empty($pageContent->acf->featured_video_thumbnail) ? htmlspecialchars(json_encode($pageContent->acf->featured_video_thumbnail)) : '' }}"
                                            data-prop-video-src="{{ $pageContent->acf->featured_video !== '' ? $pageContent->acf->featured_video : null}}"
                                            data-props='{"disableOnResponsiveSize": ["md", "lg"]}'
                                        ></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container video-middle">
                        <div class="row">
                            <div class="col-sm-8">
                                @if($pageContent->acf->featured_video !== "" || !empty($pageContent->acf->featured_video_thumbnail))
                                    <div 
                                        data-component="embedded-video"
                                        data-prop-thumbnail="{{ !empty($pageContent->acf->featured_video_thumbnail) ? htmlspecialchars(json_encode($pageContent->acf->featured_video_thumbnail)) : '' }}"
                                        data-prop-video-src="{{ $pageContent->acf->featured_video !== '' ? $pageContent->acf->featured_video : null}}"
                                        data-props='{"disableOnResponsiveSize": ["xs", "sm", "lg-x"]}'
                                    ></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container container--mk4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="docs__container">
                                @if(isset($pageContent->acf->ribbon))
                                    <div class="ribbon">{!! $pageContent->acf->ribbon !!}</div>
                                @endif                                
                                <div>
                                    @foreach($pageContent->acf->features as $feature)
                                    @php
                                        $featureVotes = (isset($voteData[$feature->title]["score"])) ? $voteData[$feature->title]["score"] : 0;
                                        $featureId = (isset($voteData[$feature->title]["id"])) ? $voteData[$feature->title]["id"] : "";
                                        $state = (isset($userVotes[$featureId])) ? $userVotes[$featureId] : "neutral";
                                    @endphp
                                        <div 
                                            data-component="feature" 
                                            data-prop-feature="{{htmlspecialchars(json_encode($feature))}}"
                                            data-n-prop-votes={{$featureVotes}}
                                            data-prop-hasvoted={{$state}}
                                            data-prop-id="{{$featureId}}"
                                            data-n-prop-hierarchy="1"
                                            data-prop-version="{{$pageContent->acf->version}}"
                                            data-prop-product="{{$pageContent->acf->product}}"
                                        ></div>
                                        @if($feature->sub_features)

                                            @foreach($feature->sub_features as $subFeature)
                                            @php
                                                $subFeatureVotes = (isset($voteData[$subFeature->title]["score"])) ? $voteData[$subFeature->title]["score"] : 0;
                                                $subFeatureId = (isset($voteData[$subFeature->title]["id"])) ? $voteData[$subFeature->title]["id"] : "";
                                                $state = (isset($userVotes[$subFeatureId])) ? $userVotes[$subFeatureId] : "neutral";
                                            @endphp
                                            <div 
                                                data-component="feature" 
                                                data-prop-feature="{{htmlspecialchars(json_encode($subFeature))}}"
                                                data-n-prop-votes={{$subFeatureVotes}} 
                                                data-prop-hasvoted={{$state}}
                                                data-prop-id="{{$subFeatureId}}"
                                                data-n-prop-hierarchy="2"
                                                data-prop-version="{{$pageContent->acf->version}}"
                                                data-prop-product="{{$pageContent->acf->product}}"                                            ></div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- TODO: restyle this section -->
                            
                            <!-- <div>
                                @if($pageContent->acf->quick_links_header !== "")
                                    <div 
                                        data-component="quick-links"
                                        data-prop-header="{{$pageContent->acf->quick_links_header}}"
                                        data-prop-quick-links="{{json_encode($pageContent->acf->quick_links)}}"
                                    ></div>
                                @endif
                            </div> -->
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
        @if($pageContent->acf->survey->display_survey && $pageContent->acf->survey->button_label !== "" && $pageContent->acf->survey->form_url !== "")
            <div 
                data-component="survey"
                data-prop-label="{{$pageContent->acf->survey->button_label}}"
                data-prop-url="{{$pageContent->acf->survey->form_url}}"
                data-prop-auto-open="{{$pageContent->acf->survey->auto_open ? 'true' : 'false'}}"
                data-prop-with-olark="{{Route::current()->parameters()['lang'] == 'en'}}"
            ></div>
        @endif
    </div>
    </div>

        @include('partials.cookie-consent')
        @include('partials.footer')

        <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
        
        <script src="{{ mix('/js/mk2/app.js') }}"></script>
        <script src="{{ mix('/js/mk4/app.js') }}"></script>
</body>
</html>
