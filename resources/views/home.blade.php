<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="xe9G8mm8XzmPJTCFGzyGsoxl71aSi0qaCDXeeyCg">
    <title>Trang chủ - PhungSu.com</title>
    <link rel="shortcut icon" type="image/png" href="http://phungsu.luongvietdung.com/public/images/ui/favicon.png">
    <!-- Styles -->
    <link href="http://phungsu.luongvietdung.com/public/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet">
    <!-- Scripts -->
    <script>
    window.Laravel = {
        "csrfToken": "xe9G8mm8XzmPJTCFGzyGsoxl71aSi0qaCDXeeyCg"
    }
    </script>
</head>

<body style="">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="http://phungsu.luongvietdung.com">
                        <img src="http://phungsu.luongvietdung.com/public/images/ui/logo.png" alt="PhungSu.com">
                        <span>Phung Su</span>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="http://phungsu.luongvietdung.com/login">Đăng nhập</a></li>
                        <li><a href="http://phungsu.luongvietdung.com/register">Đăng ký</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Dashboard</div>
                        <div class="panel-body">
                            <a href="{{url('/active_email')}}?active_email_key={{$str}}">{{$str}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>

</html>
