<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href="http://db.onlinewebfonts.com/c/1315bf42a1b093b8c55ad9721883cab4?family=NBP+Sydnie2+Scoreboard" rel="stylesheet" type="text/css"/>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    {{-- scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.16/vue.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js" charset="utf-8"></script>
    <script src="/js/io.js"></script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default red">
        <div class="container">
          <div class="row">
            <div class="col-md-3 left text-left text-lowercase">
                {{ Html::link(URL::route('game'), 'watch game',['class' => 'red']) }}
            </div>
            <div class="col-md-6 title text-center text-uppercase">
              Sjotterkas - scoreboard
            </div>
            <div class="col-md-3 right text-right text-lowercase">
              {{ Html::link(URL::route('rankings'), 'rankings',['class' => 'red']) }}

            </div>
          </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
