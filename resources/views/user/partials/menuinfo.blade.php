<div id="menuInfoInstruments" class="span3 no-print">
    <!--start right content -->
    <section class="sidebar">
        <div class="lopende-tekst">
            <h4 class="first-sidebar-title">@lang('userpage.txt_tests')</h4>
            <ul class="nav nav-list primary pull-bottom">
                <li>
                    <router-link :to="{ name: 'user.alltests' }">
                        <strong>@lang('userpage.txt_all_tests') ({{$testCnt}})</strong>
                    </router-link>
                </li>

                @foreach ($categories as $category)
                <li>

                    {{-- <router-link :to={{ "{ name: 'user.category' , params: { id: ".$category['id']."}"}}> --}}
                    <router-link :to="{ name: 'user.category' , params: { id: <?= $category['id']?> } }">

                        <strong>{{$category['title']}} ({{$category['test_cnt']}})</strong>

                    </router-link>
                </li>
                @endforeach



                {{-- <li><a id="mainmenu-all-tests" href="/all-tests/" title="All tests"><strong>All
                            tests (20)</strong></a></li>
                <li><a id="mainmenu-iq-tests" href="/iq-tests/" title="IQ tests"><strong>IQ
                            tests (13)</strong></a></li>
                <li><a id="mainmenu-iq-test" href="/iq-test/" title="Free IQ test"> Free IQ
                        test</a></li>
                <li><a id="mainmenu-classical-intelligence-test" href="/classical-intelligence-test/"
                        title="Classical intelligence test"> Classical intelligence test</a>
                </li>
                <li><a id="mainmenu-culture-fair-intelligence-test" href="/culture-fair-intelligence-test/"
                        title="Culture fair intelligence test"> Culture fair IQ test</a></li>
                <li><a id="mainmenu-career-test" href="/career-test/" title="Career test"><strong>Career
                            test</strong></a></li>
                <li><a id="mainmenu-competency-test" href="/competency-test/" title="Competency test"><strong>Competency
                            test</strong></a></li>
                <li><a id="mainmenu-personality-test" href="/personality-test/"
                        title="Personality test"><strong>Personality test</strong></a></li>
                <li><a id="mainmenu-work-values-test" href="/work-values-test/" title="Work values test"><strong>Work
                            values test</strong></a></li>
                <li><a id="mainmenu-team-roles-test" href="/team-roles-test/" title="Team roles test"><strong>Team roles
                            test</strong></a></li>
                <li><a id="mainmenu-jung-personality-test" href="/jung-personality-test/"
                        title="Jung personality test"><strong>Jung personality test</strong></a>
                </li>
                <li><a id="mainmenu-disc-personality-test" href="/disc-personality-test/"
                        title="DISC personality test"><strong>DISC personality test</strong></a>
                </li> --}}
            </ul>
        </div> <!-- end psychological tests-->
        <blockquote class=""> <i class="icon-quote-left"></i>@lang('userpage.txt_quote')<i class="icon-quote-right"></i>
        </blockquote>

        <!--end articles -->
    </section> <!-- end section sidebar -->
</div>