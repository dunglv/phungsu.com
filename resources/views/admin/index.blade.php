<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Hệ thống quản lý') - PhungSu.com</title>
    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="{{ url('/public/images/ui/favicon.png') }}" />
    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=vietnamese" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Custom CSS -->
    {{--
    <link href="css/sb-admin.css" rel="stylesheet"> --}} 
    {!!Html::style('public/css/style.css')!!} 
    {!!Html::style('public/css/common.css')!!} 
    {!!Html::style('public/css/article.css')!!} 
    {!!Html::style('public/css/sb-admin.css')!!} 
    {{-- {!!Html::style('public/css/morris.css')!!} --}} {{-- {!!Html::style('public/css/sb-admin-rtl.css')!!} --}}
    <!-- Morris Charts CSS -->
    <!-- Custom Fonts -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        {!!Html::script('/public/js/lib/jq-ui.js')!!}
    {!!Html::script('/public/js/lib/layout-masonry.min.js')!!}
    {!!Html::script('/public/js/gnlJpY4-pl-own.js')!!}
    {!!Html::script('/public/js/txB56mM-main.js')!!}
    @yield('style')
    @yield('t-script')
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        @include('admin.partials.sidebar')
        <div id="page-wrapper">
            @yield('content')
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Latest compiled and minified JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- Morris Charts JavaScript -->
    <script src="{{ url('/') }}/public/js/plugins/morris/raphael.min.js"></script>
    <script src="{{ url('/') }}/public/js/plugins/morris/morris.min.js"></script>
    <script src="{{ url('/') }}/public/js/plugins/morris/morris-data.js"></script>
    @yield('b-script')
</body>

</html>
