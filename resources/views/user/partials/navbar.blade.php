
  
<div class="navbar navbar-static-top no-print navbar-phone visible-phone">
        <div class="navbar-inner">
            <div class="container">
                <div class="mobile-icons">
                    <div class='cookie-warning' style='display: none;z-index: 10;'>
                        <p style='color: whitesmoke;'>By continuing to use this website, you agree to the use of
                            cookies. Find out more <a href="https://www.123test.com/cookies/"
                                style="color: whitesmoke;text-decoration: underline;" target="_blank">here</a>.<button
                                type='button' onclick="its123CookieClose();" style='margin-left: 15px; '
                                class='btn btn-success closecookie'><i class='icon-ok'></i>Accept cookies</button></p>
                    </div> <!-- Be sure to leave the brand out there if you want it shown --> <a class="brand" href="/">
                        <svg class="iconsvg">
                            <use xlink:href="#123testlogofull"></use>
                        </svg> </a>
                    <ul class="nav pull-right">
                        <li> <a href="/cart" id="cartIconBadge" class="cart"> <svg class="iconsvg iconsvg-cart">
                                    <use xlink:href="#icon-cart"></use>
                                </svg> <span class="badge badge-cart badge-success">1</span> </a> </li>
                        <li> <a href="/user"> <svg class="iconsvg iconsvg-user">
                                    <use xlink:href="#icon-user"></use>
                                </svg> </a> </li>
                        <li> <a id="mobile-menu-search" data-toggle="collapse" data-target=".search-menu"
                                class="btn-collapse collapsed"
                                onclick="its123RenderAction = 'action2Search';its123RenderActionTarget='mobile-menu-search';return false;">
                                <svg class="iconsvg iconsvg-search">
                                    <use xlink:href="#icon-search"></use>
                                </svg> </a> </li>
                        <li> <a id="mobile-menu-head" href="#" data-toggle="collapse" data-target=".more-menu"
                                class="btn-collapse collapsed"
                                onclick="its123RenderAction = 'action2Menu';its123RenderActionTarget='mobile-menu-head';return false;">
                                <svg class="iconsvg iconsvg-bars">
                                    <use xlink:href="#icon-bars"></use>
                                </svg> </a> </li>
                    </ul>
                </div>
                <div class="nav-collapse collapse search-menu">
                    <form class="navbar-search" method="get" onsubmit="return searchQuery(this);">
                        <div class="input-append"> <input id="m_search" type="text" name="q" required> <input
                                type="hidden" name="qa" value="search" /> <button class="btn"
                                type="submit">Search</button> </div>
                    </form>
                </div> <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse more-menu nav-main-mobile">
                    <ul class="nav">
                        <li><a href="#" data-toggle="collapse" data-target=".nav-tests" class="collapsed">Tests <svg
                                    class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down"></use>
                                </svg></a>
                            <div class="nav-collapse collapse nav-tests">
                                <ul class="nav">
                                    <li><a href="/all-tests/">All tests</a></li>
                                    <li><a href="/iq-tests/">IQ tests</a></li>
                                    <li><a href="/iq-test/">Free IQ test</a></li>
                                    <li><a href="/career-test/">Career test</a></li>
                                    <li><a href="/competency-test/">Competency test</a></li>
                                    <li><a href="/personality-test/">Personality test</a></li>
                                    <li><a href="/work-values-test/">Work values test</a></li>
                                    <li><a href="/team-roles-test/">Team roles test</a></li>
                                    <li><a href="/jung-personality-test/">Jung personality test</a></li>
                                    <li><a href="/disc-personality-test/">DISC personality test</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#" data-toggle="collapse" data-target=".nav-articles" class="collapsed">Articles
                                <svg class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down"></use>
                                </svg></a>
                            <div class="nav-collapse collapse nav-articles">
                                <ul class="nav">
                                    <li><a href="/articles/assessment/">Assessment</a></li>
                                    <li><a href="/articles/work-values/">Work values</a></li>
                                    <li><a href="/articles/disc-typology/">DISC typology</a></li>
                                    <li><a href="/articles/iq-and-intelligence/">IQ and intelligence</a></li>
                                    <li><a href="/articles/career-choice/">Career choice</a></li>
                                    <li><a href="/articles/personality/">Personality</a></li>
                                    <li><a href="/articles/team-roles/">Team roles </a></li>
                                    <li><a href="/articles/jung-typology/">Jung typology</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="/professions/">List of professions</a></li>
                        <li><a href="#" data-toggle="collapse" data-target=".nav-business" class="collapsed">Business
                                <svg class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down"></use>
                                </svg></a>
                            <div class="nav-collapse collapse nav-business">
                                <ul class="nav">
                                    <li><a href="/business/">Using our tests</a></li>
                                    <li><a href="/tickets/">Tickets for tests</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#" data-toggle="collapse" data-target=".nav-help" class="collapsed">Help <svg
                                    class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down"></use>
                                </svg></a>
                            <div class="nav-collapse collapse nav-help">
                                <ul class="nav">
                                    <li><a href="/help/">Frequently asked questions</a></li>
                                    <li><a href="/about_123test/">About 123test</a></li>
                                    <li><a href="/used-and-mentioned/">Used and mentioned</a></li>
                                    <li><a href="/contact/">Contact</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#" data-toggle="collapse" data-target=".nav-language" class="collapsed">EN <svg
                                    class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down"></use>
                                </svg></a>
                            <div class="nav-collapse collapse nav-language">
                                <ul class="nav">
                                    <li><a id="language-switch-url-mobile-es" href="/es/">Español (ES)</a></li>
                                    <li><a id="language-switch-url-mobile-fr" href="/fr/">Français (FR)</a></li>
                                    <li><a id="language-switch-url-mobile-nl" href="https://www.123test.nl/">Nederlands
                                            (NL)</a></li>
                                    <li><a id="language-switch-url-mobile-de" href="https://www.123test.de/">Deutsch
                                            (DE)</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav mobile-logout" style="display: none">
                        <li><a href="/user/log-out/">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div><!-- End navbar-inner -->
    </div>
    <div class="navbar navbar-static-top no-print navbar-phone visible-phone" style="position: absolute; z-index: 998;">
        <div class="navbar-inner navbar-inner-small">
            <div class="container">
                <p class="navbar-text pull-left"> Free psychological tests (<span
                        class="countTestLastMonth">917,254</span> taken last month) </p>
            </div>
        </div>
    </div>