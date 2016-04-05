<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sjotterkas</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href="http://db.onlinewebfonts.com/c/1315bf42a1b093b8c55ad9721883cab4?family=NBP+Sydnie2+Scoreboard" rel="stylesheet" type="text/css"/>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="apple-touch-icon" sizes="57x57" href="/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/fav/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    {{-- scripts --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.16/vue.min.js" charset="utf-8"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.19/vue.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js" charset="utf-8"></script>
    <script src="/js/io.js"></script>
</head>
<body id="app-layout" class="bgWhite">
    <nav class="navbar navbar-default red bgWhite ">
        <div class="container">
          <div class="row">

            <div class="col-md-offset-2 col-md-6 title text-center text-uppercase">
              Sjotterkas - scoreboard
            </div>

          </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
