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

            .highlight1 {
                background-color: #FF0;
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
                <h1 id="songtitle">
                    <?php
                        //var_dump($data);
                        echo $data[1];
                    ?>
                </h1>

                <div class="songs">
                    <p id="lyricContent">
                        <?php
                            echo $data[2];
                        ?>
                    </p>
                    
                </div>

                <div class="buttons">
                    <button id="backToSongsButton" onclick="window.location='{{ url("song") }}'">Back to Songs</button>
                    <button id="backToCloudButton" onclick="window.location='{{ url("cloud") }}'">Back to Cloud</button>
                </div>
            </div>
        </div>

        <script>

            var content = document.querySelector('#lyricContent').innerHTML;
            content = content.toLowerCase();
            content = content.replace('******* this lyrics is not for commercial use *******', '');
            content = content.replace(/[\])[(]/g, '');
            content = content.replace(/\d*/g, '');

            highlightText();

            function highlightText(){
                //console.log('this is the content of the lyrics: ' + content);

                //var highlight = document.querySelector('#songtitle').innerHTML;
                var word = {!! json_encode($data[0]) !!};
                var highlight = word.toLowerCase();
                var regExpObj = new RegExp(highlight, 'g');

                console.log('this is the word: ' + highlight);

                var newStr = '<span class="highlight1">' + highlight + '</span>';

                document.querySelector('#lyricContent').innerHTML = content.replace(regExpObj, newStr);
            
            }

        </script>
    </body>
</html>
