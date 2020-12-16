@php 
isset(Route::current()->parameters()["region"]) ? $region = Route::current()->parameters()["region"] : $region = '';
isset(Route::current()->parameters()["lang"]) ? $lang = Route::current()->parameters()["lang"] : $lang = '';
// $region = Route::current()->parameters()["region"];
// $lang = Route::current()->parameters()["lang"];
@endphp

<header class="header header--ghost">
    <div class="container header__container">
        <div class="header__search-wrap">
            <div class="header__nav-wrap right-align-dropdowns">
                <a href="/{{$region}}/{{$lang}}">
                    <img class="header__logo" src="/img/CaseWare_logo_RGB_horz_White.png" alt="CaseWare logo">
                </a>
                <!-- @if(strpos(Request::url(), '/SE-Authoring/') == false)
                    @include('partials.nav')
                @endif -->
            </div>
        </div>
    </div>
</header>
