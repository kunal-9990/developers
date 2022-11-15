
<header class="header">
    <div class="container header__container">
        <div class="header__search-wrap">
            <div class="header__nav-wrap">
                <a href="/"><img class="header__logo" src="/img/CaseWare-Logo-RGB-Primary_Dark-TM.png"
                        alt="CaseWare logo"></a>
            </div>

            @if(request()->path() !== "login")
                <div class="header__input-search-wrapper">
                    <form method="GET" action="/new-search">
                        <input type="text" name="search" placeholder="{{ __('strings.search') }}" autocomplete="off">
                    </form>
                </div>
            @endif
            <div class="header__links">
                @if(strpos(Request::url(), '/SE-Authoring/') == false && request()->session()->get('license') != 'SherlockApi')
                    @include('partials.nav')
                @endif
            </div>            
        </div>
    </div>
</header>