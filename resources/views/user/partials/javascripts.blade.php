<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="{{url('js/123test.js')}}" type="text/javascript"></script>


<script>
    window.laravel = <?php 
        echo json_encode([
            'categories'    =>  $categories
        ]);
    ?>;
</script>

<script src="/js/lang.js"></script>
<script src="{{ url('/client/js/manifest.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('/client/js/vendor.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ url('/client/js/user.js') }}" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>


@yield('javascript')