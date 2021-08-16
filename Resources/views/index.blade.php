<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="./favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.btekno.id/templates/console/css/vendor.min.css">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/console/vendor/icon-set/style.css">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/console/css/theme.min.css?v={{ config('console.version') }}">
    <link rel="stylesheet" href="https://cdn.btekno.id/templates/console/css/custom.css?v={{ config('console.version') }}">

    @yield('css')

    <style>
        html {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
        body {
            height: 100%;
            padding: 0;
            overflow: auto;
            margin: 0;
            -webkit-overflow-scrolling: touch;
        }
        .navbar-fixed~.main {
            margin-top: 3.8rem;
        }
        @media (min-width: 992px) {
            .navbar-vertical.navbar-expand-lg {
                min-height: 84vh;
                position: fixed;
                width: 100%;
            }
        }
        @media (max-width: 991.98px) {
            .navbar-fixed~.main {
                margin-top: 0;
            }
        }
        
        .min-height-275px {
            min-height: calc(100vh - 200px);
        }
        .min-height-200px {
            min-height: calc(100vh - 200px);
        }
    </style>

</head>
<body class="" data-offset="80" data-hs-scrollspy-options='{ "target": "#navbarSettings" }'>
    
    @include('console::layouts.partials.header')
    
    <main id="content" role="main" class="main" style="overflow-x: hidden;">
        <div class="bg-light">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.btekno.id/templates/console/js/vendor.min.js"></script>
    <script src="https://cdn.btekno.id/templates/console/js/theme.min.js"></script>
    <script>
        $(document).on('ready', function () {
            $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
                $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
            });
            var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
                desktop: {
                    position: 'left'
                }
            }).init();
            var sidebar = $('.js-navbar-vertical-aside').hsSideNav();
            $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
            $(".js-nav-tooltip-link").on("show.bs.tooltip", function(e) {
                if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                    return false;
                }
            });
            $('.js-hs-unfold-invoker').each(function () {
                var unfold = new HSUnfold($(this)).init();
            });
            $('.js-form-search').each(function () {
                new HSFormSearch($(this)).init()
            });
        });
    </script>

    @yield('js')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @include('sweet::alert')

    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="/assets/vendor/babel-polyfill/polyfill.min.js"><\/script>');
    </script>
</body>
</html>