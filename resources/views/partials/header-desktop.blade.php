@php
$year = Route::current()->parameters()["year"];
$product = Route::current()->parameters()["product"];
$version = Route::current()->parameters()["version"];
$lang = Route::current()->parameters()["lang"];
$searchroute = '';

if(strpos(Request::url(), '/SE-Authoring/') == true && strpos(Request::url(), '/se-search/') == true) {
$searchroute = "se-search";
}
else if(strpos(Request::url(), '/SE-Builder/') == true && strpos(Request::url(), '/se-builder-search/') == true) {
$searchroute = "se-search";
}
else {
$searchroute = "search";
}

$searchURL = route($searchroute, [$year, $product, $version, $lang]);
$indexURL = route('category', [$year, $product, $version, $lang, 'webapps']);
@endphp
<header class="header-desktop">
    <div class="container header__container">
        {{-- <div class="row"> --}}
        <div class="header__search-wrap">
            <div class="header__nav-wrap">
                <a @if(isset($link)) href={{$link}} @else href="{{$indexURL}}" @endif><img class="header__logo" 
                    
                    @if(!isset($logo))
                        src="/img/CaseWare_logo_4C_horz.svg"
                    @elseif($logo == "audit")
                        src="/img/CW-Audit-22.svg"
                    @elseif($logo == "working-papers")
                        src="/img/CW-wp-2020.svg"
                    @endif
                        alt="CaseWare logo"></a>
                <!-- @if(strpos(Request::url(), '/SE-Authoring/') == false)
                @include('partials.nav')
                @endif -->
            </div>
            <div class="header__input-search-wrapper">
                <form method="GET" action="{{$searchURL}}">
                    <input type="text" name="search" placeholder="{{ __('strings.search') }}" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="expanded-filters">
            {{-- <div class="dropdown-content"> --}}
            @include('partials.filters', ['mobile' => false])
            {{-- </div> --}}
        </div>
    </div>
</header>