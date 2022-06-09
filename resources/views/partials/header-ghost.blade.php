<header class="header header--ghost">
    <div class="container header__container">
        <div class="header__search-wrap">
            <div class="header__nav-wrap right-align-dropdowns">
                <a href="/">
                    <img class="header__logo" src="/img/CaseWare-Logo-RGB-Primary_Light-TM.png" alt="CaseWare logo">
                </a>
                <!-- @if(strpos(Request::url(), '/SE-Authoring/') == false)
                    @include('partials.nav')
                @endif -->
                <div class="dev-header">
                    @if($authenticated)
                        <div class="cta">
                            <a href="/logout">Log out</a>
                        </div>
                    @else
                        <a href="https://my.caseware.com/account/login?ReturnUrl=%2F">Sign up</a>
                        <div class="cta">
                            <a href="/login">Log in</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
