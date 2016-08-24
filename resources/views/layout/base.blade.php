<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>ADHL</title>

    <!-- Bootstrap core CSS -->
    {!! Html::style('lib/bootstrap/bootstrap.min.css') !!}

            <!-- Custom styles for this template -->
    {!! Html::style('css/dashboard.css') !!}

    @yield('head')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

@include('layout.navbar')

<div class="container-fluid">
    <div class="row">
        @if(Auth::check())
            <div class="col-sm-3 col-md-2 sidebar">
                @include('layout.sidebar')
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        @else
            <div class="col-md-12">
        @endif
                        @yield('container')
            </div>
    </div>
</div>
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
{!! Html::script('lib/bootstrap/bootstrap.min.js') !!}
@show
</body>
</html>