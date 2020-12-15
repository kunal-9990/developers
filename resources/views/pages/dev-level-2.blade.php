@extends('default')

@section('html')
    @include('partials.html', [
        'exclusiveTo' =>  isset($exclusiveTo) ? $exclusiveTo : false,
    ])
@stop

@section('meta')
    @include('partials.meta', [
        'canonical' => URL::current(),
        'url' => URL::current(),
        'title' =>  isset($title) ? $title : false,
        'og_description' => isset($title) ? $title : false,
        'doNotTranslate' => isset($doNotTranslate) ? $doNotTranslate : false,
    ])
@stop

@section('content')
    <div class="container documentation">
        <div class="row">
            <div class="col-sm-3 table-of-contents">
                @if(isset($pageContent->acf->toc)) 
                  <div
                      data-component="toc" 
                      data-prop-toc="{{htmlspecialchars(json_encode($pageContent->acf->toc))}}"
                  ></div>
                @endif
            </div>
            <div class="col-sm-9">
                <div class="docs__video-iframe-wrap">
                    @include('partials.video-iframe')
                </div>
                <div class="docs__container">
                    <div class="docs__content"> 
                    <h1>Dev 2</h1>

                    </div>
                    <div class="docs__sub-toc">
                        <div class="docs__video-iframe-thumbnail-container">
                            <img class="docs__video-iframe-thumbnail" src="" alt="">
                            <img class="docs__video-iframe-thumbnail__yt-icon" src="/img/yt_icon_rgb.png" alt="">
                        </div>
                    </div>
                </div>
                @include('partials.filter-msg', [
                    'exclusiveTo' =>  isset($exclusiveTo) ? $exclusiveTo : false,
                ])
            <!-- </div> -->
        </div>
    </div>

    {{-- back to top button --}}
    @include('partials.back-to-top')

    {{-- modal overlay for images in content --}}
    @include('partials.image-modal')

    {{-- modal overlay for email subscription and pdf download --}}
    @include('partials.download-pdf')
@stop