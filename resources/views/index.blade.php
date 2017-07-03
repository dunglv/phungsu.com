<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang chủ') - PhungSu.com</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="{{ url('/public/images/ui/favicon.png') }}" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {!!Html::style('/public/css/common.css')!!}
    {!!Html::style('/public/css/style.css')!!}
    {!!Html::style('/public/css/article.css')!!}
    <!-- Styles -->
    {{--
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> --}} {{--
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald:300,400,600" rel="stylesheet">
    {!!Html::script('/public/js/lib/jq-ui.js')!!}
    @yield('style')
    @yield('t-script')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('ui.home') }}">{!!Html::image('/public/images/ui/logo.png')!!}</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    @if(isset($__CATEGORY))
                        <ul class="nav navbar-nav">
                        @foreach ($__CATEGORY as $__CATE)
                            <li @if(url()->current() === route('ui.category.detail', $__CATE->slug)) class="active" @endif><a href="{{ route('ui.category.detail', $__CATE->slug) }}">{{$__CATE->title}}</a></li>
                        @endforeach
                        </ul>
                    @endif
                    {{-- <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Giáo lý</a></li>
                        <li><a href="#">Nhạc</a></li>
                        <li><a href="#">Ảnh</a></li>
                        <li><a href="#">Tin tức</a></li>
                    </ul> --}}
                    <form class="navbar-form navbar-left" role="search" method="GET" action="{{ route('ui.search.result') }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" value="{{ old('q') }}" placeholder="Bạn muốn tìm kiếm gì?">
                        </div>
                        <button type="submit" class="btn btn-default">Tìm</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('ui.create') }}" class="contribute"><span class="w-pl"><span class="b-pl"><i class="fa fa-plus"></i></span> Viết bài</a></span>
                        </li>
                        @if(Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">Post</a></li>
                                <li>
                                {!!Form::open(['url' => '/logout', 'method' => 'POST'])!!}
                                    <button type="submit">Logout</button>
                                {!!Form::close()!!}
                                </li>
                            </ul>
                        </li>
                        @else
                            <li><a href="{{ url('/login') }}" class="contribute">Login</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
        <div id="wp_content">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="col-md-12 col-sm-12">
                    @ 2017 phungsu.com - Powered by Phung su
                </div>
            </div>
        </footer>
    </div>
    @yield('b-script')
</body>

</html>
