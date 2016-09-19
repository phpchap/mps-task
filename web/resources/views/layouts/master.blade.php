<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>MPS - Tasks</title>
        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/css/modern-business.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Lobibox CSS -->
        <link rel="stylesheet" href="/css/lobilist.min.css">
        <link rel="stylesheet" href="/css/lobibox.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- /.container -->
        </nav>

        @yield('content')

        <!-- /.container -->
        <!-- jQuery -->
        <script src="/js/jquery.js"></script>
        <!-- jQueryUI -->
        <script src="/js/jquery-ui.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/js/bootstrap.min.js"></script>

        <!-- Lobibox -->
        <script src="/js/lobilist.min.js"></script>
        <script src="/js/lobibox.min.js"></script>

        @yield('javascript')

    </body>
</html>