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
            <div class="col-sm-3 table-of-contents manual-toc">
                @if(isset($nav))
                    <div class="manual-toc__container">
                        <ul class="toc">
                            <li class="manual-toc__category manual-toc__category--is-open">
                                <a class="chevron" href="#">
                                    Key Pages
                                </a>
                            </li>
                            <ul class="manual-toc__sub-category-wrap manual-toc__sub-category-wrap--is-expanded">
                            {!!$nav!!}
                            </ul>
                        </ul>
                    </div>
                @endif               
                @include('partials.toc')
            </div>
            <div class="col-sm-9">
                <div class="docs__video-iframe-wrap">
                    @include('partials.video-iframe')
                </div>
                <div class="docs__container">
                    <div class="docs__content"> 
                        @if(isset($dom))
                            @include('partials.toc-content', ['content' => $dom])
                        @endif
                        <div class="docs__user-feedback">
                            @include('partials.user-feedback')
                        </div>
                    </div>
                    <div class="docs__sub-toc">
                        @include('partials.sub-toc')
                    </div>
                </div>
                @include('partials.filter-msg', [
                    'exclusiveTo' =>  isset($exclusiveTo) ? $exclusiveTo : false,
                ])
            </div>
        </div>
    </div>

    {{-- back to top button --}}
    @include('partials.back-to-top')

    {{-- modal overlay for images in content --}}
    @include('partials.image-modal')

    {{-- modal overlay for email subscription and pdf download --}}
    @include('partials.download-pdf')
@stop