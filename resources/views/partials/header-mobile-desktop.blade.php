<header class="header-mobile-desktop">
    <span class="glyphicon glyphicon-menu-hamburger header-mobile__nav-toggle" aria-hidden="true"></span>
    <div>
        <img class="header-mobile__logo" 
            @if(!isset($logo))
                    src="/img/CaseWare_logo_4C_horz.svg"
                @elseif($logo == "audit")
                    src="/img/CW-Audit-22.svg"
                @elseif($logo == "working-papers")
                    src="/img/CW-wp-2020.svg"
            @endif
        alt="CaseWare Cloud logo">
    </div>
    <div class="header-mobile__input-search-wrapper">
        @php
        $year = Route::current()->parameters()["year"];
        $product = Route::current()->parameters()["product"];
        $version = Route::current()->parameters()["version"];
        $lang = Route::current()->parameters()["lang"];
        $searchURL = route('search', [$year, $product, $version, $lang]);
        @endphp
        <form method="GET" action="{{$searchURL}}">
            <input type="text" name="search" placeholder="Search" autocomplete="off">
        </form>
        <span class="glyphicon glyphicon-remove header-mobile__close-search header-mobile__search--js"
            aria-hidden="true"></span>
    </div>
    <span class="glyphicon glyphicon-search header-mobile__open-search header-mobile__search--js"
        aria-hidden="true"></span>
</header>

{{-- mobile overlay & nav(TOC) --}}
<div class="mobile-nav__wrapper">
    <div class="mobile-nav">
        <div class="mobile-nav__close-bar-wrap">
            <span class="glyphicon glyphicon-chevron-left header-mobile__nav-toggle" aria-hidden="true"></span>
            {{-- @include('partials.nav') --}}
        </div>
        <div class="mobile-nav__filters-wrap">
            @include('partials.filters', ['mobile' => true])
        </div>
        <div class="mobile-nav__toc">
            @include('partials.toc')
        </div>
        <div class="mobile-nav__links">
            @include('partials.nav-mobile')
        </div>
    </div>
</div>