<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">

    @yield('meta')

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/mainsite/libs.css') }}" rel="stylesheet">
</head>
<body>
    @yield('header')


    @yield('slider')


    @yield('content')

    <div class="modal fade" id="add_to_cart_notify" role="dialog">

    </div><!-- /modal -->
    @yield('section-blog')


    @yield('footer')



	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/mainsite/libs.js') }}"></script>
    <script src="{{ asset('js/mainsite/cart.js') }}"></script>
	<script type="text/javascript">
        $('.dropdown-toggle').dropdown();
        $('#main_slider').carousel({
            interval: 5000 //changes the speed
        });
        $('#1st_sub_slider').carousel({
            interval: 3500 //changes the speed
        });
        $('#2nd_sub_slider').carousel({
            interval: 3500 //changes the speed
        });

        $('#item_carousel').carousel({
            interval: 10000 //changes the speed
        });
        $('.img_indicators li').click(function() {
          var $this = $(this);
          var current = $this.children().children().attr('src');
          $this.siblings().removeClass('active');
          $this.addClass('active');
        });
        $(document).ready(function(){


            $('.items-carousel').slick({
              dots: false,
              infinite: false,
              speed: 300,
              slidesToShow: 4,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
            });
        });
    </script>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="356955021359698">
    </div>
    @yield('scripts')
</body>
</html>