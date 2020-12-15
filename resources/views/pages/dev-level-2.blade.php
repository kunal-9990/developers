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
    <div class="container documentation dev-landing dev-landing--level2">
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
                <div class="docs__container">
                    <div class="docs__content"> 
                      <section class="toc-content">
                        <div>
                          <h1><?php echo $pageContent->acf->page_title ?></h1>
                          @if(isset($pageContent->acf->modular_template_builder)) 
                            <div class="dev-level-2">
                              @foreach($pageContent->acf->modular_template_builder as $section) 
                                @if($section->acf_fc_layout == "text_area")
                                  {!! $section->text_area !!}
                                @endif
                                @if($section->acf_fc_layout == "links")
                                  <div class="dev-level-2__links">
                                    <strong>{{ $section->link_group_title }}</strong>
                                    @foreach($section->links as $link)
                                    <a href="{{ $link->link->url }}" target="{{ $link->link->target }}">
                                      {{ $link->link->title }}
                                    </a>
                                    @endforeach
                                  </div>
                                @endif
                              @endforeach
                            </div>
                          @endif
                        </div>
                      </section>
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