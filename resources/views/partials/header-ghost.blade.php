<header class="header header--ghost">
    <div class="container header__container">
        <div class="header__search-wrap">
            <div class="header__nav-wrap right-align-dropdowns">
                <a href="/">
                    <img class="header__logo" src="/img/CaseWare_logo_RGB_horz_White.png" alt="CaseWare logo">
                </a>
                <!-- @if(strpos(Request::url(), '/SE-Authoring/') == false)
                    @include('partials.nav')
                @endif -->
                <div class="dev-header">
                    <a href="cta">Sign up</a>
                    <div class="cta">
                        @if($authenticated)
                            <a href="/logout">Log out</a>
                        @else
                            <a href="/login">Log in</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
