<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SongCloud - Lyrics</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body {
                background-color: gray;
                font-size: 120%;
                font-family:Arial, Helvetica, sans-serif;
            }

            input, button {
                font-family:Arial, Helvetica, sans-serif;
                font-size: 120%;
            }

            h1 {
                margin: 15px;
            }

            p {
                display: block;
                margin:15px;
            }

            .buttons {
                position:absolute;
                bottom:0;
            }

            button {
                background-color: mediumpurple;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <p> Hello, {{ $name }} </p>
            
        </div>
    </body>
</html>
