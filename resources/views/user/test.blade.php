<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.partials.head')
    <style>
        html {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 94vh;
        }

        #userPage {
            /* background-color: #e3f2fd; */
            flex: 1;
            /* padding: 20px; */
        }
    </style>

    <link rel="stylesheet" href="{{ url('css/iqtestnow.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

</head>

<body id="body-container" class="testBody">

    @include('user.partials.svg')

    {{-- @include('user.partials.header') --}}
    <header class="header header-test" style="background-color:#404040">
        <div class="header__container">
            <div class="header__logo">
                <a href='/' title='123test' alt="">
                    <svg class="iconsvg">
                        <use xlink:href="#123testlogofull"></use>
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <div id="userPage" class="wrapper">
        @include('user.partials.test_content')
        {{-- @include('user.partials.navbar') --}}
        <i class="scroll-down active" data-scroll=".footer"></i>
        <footer class="footer">
            <div class="footer__container">
                <div class="footer__logo">
                    <a href="/">
                        <!-- <img
                src="/assets/logo-790335b26cb576ba9c6d9de345d63b19df4de1f1ea5d81f87bbc61edaa5386c1.svg"
                alt="Logo"
              > -->
                    </a>
                    <p>© 2019 YourOwnTest<sup>®</sup>. All rights reserved.</p>
                </div>

                <div class="footer__contact image">
                    <!-- <img
              src="/assets/contact-info/footer/default-ef2d17c4c5dbd888d69eeb0bf6e78770105742ba1afacb88fd16c508928c769d.png"
              alt="Default"
            >
            <img
              src="/assets/visa-master-cards@2x-c1a8f870a8d7b00bac9247cdd1c2ffed9e01302d5ed6b1674516e6df025e86b9.png"
              alt="Visa master cards@2x"
            > -->
                </div>
            </div>
        </footer>
    </div>

    {{-- @include('user.partials.footer') --}}

    @include('user.partials.javascripts')



</body>

</html>