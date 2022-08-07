<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.partials.head')
    <link rel="stylesheet" href="{{ url('css/123test.css') }}">
</head>

<body id="body-container" class="mainBody boxed">

    @include('user.partials.svg')
    @include('user.partials.header')
    <div id="userPage">
        @include('user.partials.navbar')
        <div class="body">
            <div role="main" class="main" style="min-height:70vh">
                <div class="container">
                    <section>
                        <!--start main section with article, test and sidebar with navigation -->
                        <div class="row">

                            @include('user.partials.content')
                            @include('user.partials.menuinfo')

                        </div>
                        <!--end row -->
                    </section>
                </div>
            </div>
        </div>
    </div>

    @include('user.partials.footer')
    @include('user.partials.javascripts')


</body>

</html>