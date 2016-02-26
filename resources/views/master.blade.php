<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="RaffleDraw Winner Generator">
    <meta name="author" content="RaffleDraw.online">
    <meta name="keywords" content="RaffleDraw,raffle,random,generator,draw,piesse,mapdev">
    <meta property="og:site_name" content="RaffleDraw"/>
    <meta property="og:type" content="website"/>
    @yield('metatags')

    <title>@yield('title', 'RaffleDraw')</title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/jquery.cookiecuttr/1.0/cookiecuttr.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }

        nav {
            background-image: url("{{asset('pattern.png')}}");
        }

        .clear {
            display: table-cell;
        }

        .img-responsive {
            margin: 0 auto;
        }
    </style>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('')}}"><i class="fa fa-random fa-fw fa-lg"></i> Raffle Draw</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                {{--<li>--}}
                {{--<a href="about"><i class="fa fa-fw fa-info"></i> About</a>--}}
                {{--</li>--}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href=""><i class="fa fa-fw fa-clock-o"></i> {{Carbon::now()->format('D j M Y H:i:s e')}}
                    </a>
                </li>
                <li><a href="">
                        <small>{{Helpers::appVersion()}}</small>
                    </a></li>
            </ul>
        </div>

    </div>
</nav>

<!-- Page Content -->
<div class="container-fluid">
    @yield('content')
</div>

<!-- jQuery Version 1.11.1 -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.cookiecuttr/1.0/jquery.cookiecuttr.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/socialite/2.1.0/socialite.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.8/clipboard.min.js"></script>

<script>
    //    if (jQuery.cookie('cc_cookie_decline') == "cc_cookie_decline") {
    // do nothing
    //    } else {
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-74246203-1', 'auto');
    ga('send', 'pageview');
    //    }
    $(document).ready(function () {
//        $.cookieCuttr({
//            cookieDiscreetLink: true,
//            cookiePolicyPage: false,
//            cookieDiscreetPosition:'bottomright'
//        });
    });
</script>

@yield('javascript')

</body>

</html>
