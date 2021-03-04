@php
    isset(Route::current()->parameters()["lang"]) ? $lang = Route::current()->parameters()["lang"] : $lang = '';
    isset(Route::current()->parameters()["region"]) ? $region = Route::current()->parameters()["region"] : $region = '';
@endphp
<div class="nav-container">
@if(!empty($region))
    <div class="region__dropdown dropdown">
        <a href="#"><i class="fas fa-globe-americas"></i> {{strtoupper($region)}} <i class="fas fa-angle-down"></i></a>
        <div class="dropdown-content">
            <a href="/{{ str_replace($region.'/' , 'int/', Request::path()) }}">International</a>
            <a href="/{{ str_replace($region.'/' , 'ca/', Request::path()) }}">Canada</a>
            <a href="/{{ str_replace($region.'/' , 'us/', Request::path()) }}">US</a>
            <a href="/{{ str_replace($region.'/' , 'nl/', Request::path()) }}">NL</a>
        </div>
    </div>
@endif
@if(!empty($lang))
    <div class="language__dropdown dropdown">
        <a href="#"><i class="fas fa-language"></i> {{strtoupper($lang)}} <i class="fas fa-angle-down"></i></a>
        <div class="dropdown-content">
            <a href="/{{ str_replace('/'.$lang ,'/en', Request::path()) }}">English</a>
            <a href="/{{ str_replace('/'.$lang ,'/fr', Request::path()) }}">French</a>
            <a href="/{{ str_replace('/'.$lang ,'/es', Request::path()) }}">Spanish</a>
            <a href="/{{ str_replace('/'.$lang ,'/nl', Request::path()) }}">Dutch</a>
            <a href="/{{ str_replace('/'.$lang ,'/cn', Request::path()) }}">Chinese</a>
            <a href="/{{ str_replace('/'.$lang ,'/de', Request::path()) }}">German</a>
        </div>
    </div>
    @endif

    @if (isset($header))
        <div class="header__dropdown">
            <ul>
                @foreach($header as $item)
                    @if(isset($item->child_items))
                        <li class="subnav">
                            <span class="parent">{{ $item->title }}</span>
                            <ul class="children">
                                @foreach($item->child_items as $child)
                                    <li>
                                        <a href="{{ $child->url }}" target="{{ $child->target }}">{{ $child->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else 
                        <li><a href="{{ $item->url }}" target="{{ $item->target }}" class="parent">{{ $item->title }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>
