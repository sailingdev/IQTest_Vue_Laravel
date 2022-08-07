<header
    class="its123-fixed-header desktop hidden-phone no-print {{Request::is('user/main/*')?'test-fix-header':'unfix-header'}}">
    <div class="container">
        <div class="row">
            <div class='cookie-warning' style='display:none;z-index: 10;'>
                <p style='color: whitesmoke;'>By continuing to use this website, you agree to the use of cookies.
                    Find out more <a href="https://www.123test.com/cookies/"
                        style="color: whitesmoke;text-decoration: underline;" target="_blank">here</a>.<button
                        type='button' onclick="its123CookieClose();" style='margin-left: 15px; '
                        class='btn btn-success closecookie'><i class='icon-ok'></i>Accept cookies</button></p>
            </div>
            <div class="span2 site-logo-container">
                <div class="logo"> <a href='/' title='123test' alt=""> <svg class="iconsvg logo-full">
                            <use xlink:href="#123testlogofull"></use>
                        </svg> <svg class="iconsvg logo-icon">
                            <use xlink:href="#123testlogoIcon"></use>
                        </svg> </a> <span class="subtitle"> @lang('userpage.txt_home_title') </span> </div>
            </div>
            <div class="span10">
                <div class="desktop-menu">
                    <nav>
                        <ul class="nav nav-pills nav-main">
                            <li class="{{Request::is('user/main/*')?'hidden':''}} dropdown"><a href="#"
                                    data-toggle="dropdown" class="dropdown-toggle disabled">@lang('userpage.txt_tests')
                                    ({{$testCnt}})
                                    <svg class="iconsvg iconsvg-chevron-down">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down">
                                        </use>
                                    </svg>
                                </a>
                                <ul class="dropdown-menu" role="menu">

                                    <li>
                                        <a href="/user/home/all-tests">
                                            <strong>@lang('userpage.txt_all_tests') ({{$testCnt}})</strong>
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li>
                                        <a href=<?= "/user/home/category/". $category['id'] ."/tests"?>>{{$category['title']}}
                                            ({{$category['test_cnt']}})</a>

                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                            {{--  <li class="dropdown {{Request::is('user/main/*')?'hidden':''}}"><a rel="nofollow"
                                href="/user" data-toggle="dropdown" class="dropdown-toggle disabled"><svg
                                    class="iconsvg iconsvg-user">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-user">
                                    </use>
                                </svg><svg class="iconsvg iconsvg-info">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down">
                                    </use>
                                </svg></a>
                            <ul id="desktop-menu-user" class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a rel="nofollow" href="/user/">Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                </li>
                                <li id="meta-user-logout" style="display:none"> <a rel="nofollow"
                                        href="/user/log-out">Log out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                </li>
                                <li id="meta-user-login" style="display:none"> <a rel="nofollow" href="/user/login">Log
                                        in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> </li>
                            </ul>
                            </li> --}}
                            <li class="dropdown {{Request::is('user/main/*')?'hidden':''}}"><a href="#"
                                    data-toggle="dropdown" class="dropdown-toggle disabled">{{$locale}}<svg
                                        class="iconsvg iconsvg-chevron-down">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#chevron-down">
                                        </use>
                                    </svg></i></a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @foreach ($languages as $language)
                                    <li><a id="language-switch-url-es"
                                            href="/user/home?locale=<?= $language->locale ?>">{{$language->language}}
                                            ({{$language->locale}})</a></li>
                                    @endforeach
                                    {{-- <li><a id="language-switch-url-es" href="/es/">Español (ES)</a></li>
                                    <li><a id="language-switch-url-fr" href="/fr/">Français (FR)</a></li> --}}

                                    {{-- <li><a id="language-switch-url-nl" href="https://www.123test.nl/">Nederlands
                                                (NL)</a></li>
                                        <li><a id="language-switch-url-de" href="https://www.123test.de/">Deutsch
                                                (DE)</a></li> --}}
                                </ul>
                            </li>
                            <li> <a rel="nofollow" href="/cart" class="cart" style="display: none;"> <svg
                                        class="iconsvg iconsvg-cart">
                                        <use xlink:href="#icon-cart"></use>
                                    </svg> <span id="badge-cart" class="badge badge-cart badge-success">1</span>
                                </a> </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div id="its123CounterSubHeader" class="sub-header show-sub" style="display: none">
        <div class="container">
            <div class="counter"> <svg class="icon-outline-svg icon-assessment-outline">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-assessment-outline"></use>
                </svg> <span class="its123-count active">917,254</span> tests completed in the last 30 days </div>
        </div>
    </div>
</header>