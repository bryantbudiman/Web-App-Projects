<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SongCloud - Songs</title>
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

            a {
                display: block;
                margin:15px;
            }

            button {
                background-color: mediumpurple;

                position:absolute;
                bottom:0;
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

            <div class="content">
                <?php
                    echo "<h1>" . $data['word'] . "</h1>";
                ?>

                <ul id='songlistarray'>
                <!-- embedded php block that loops through the $songs array to display links -->
                 
                </ul>

                <ul style="list-style: none;">
                <?php

                    // var_dump($hasharray);
                    // example to display
                    foreach ($data['word_song_freq_map'][$data['word']] as $k => $v) {
                        // var_dump('the song is: ' . $k);
                        // var_dump('the word is: ' . $v);
                        echo "<li><a href='http://127.0.0.1:8000/lyrics/" . $k . '/' . $data['word'] . "'>" . $k . " (" . $v . ")</a></li>";
                    }
                ?>
                </ul>


                <div class="songs">

                </div>

                <div class="buttons">
                    <button id="backButton">Back</button>
                </div>
            </div>
        </div>

    </body>
</html>
