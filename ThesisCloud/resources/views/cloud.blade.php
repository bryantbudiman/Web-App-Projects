<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SongCloud - Cloud</title>

        <script type="text/javascript" src="{{ URL::asset('js/lib/d3/d3.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/lib/d3/d3.layout.cloud.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/d3.wordcloud.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/example/example.words.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/html2canvas.js') }}"></script>

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '332918383776701',
                xfbml: true,
                version: 'v2.8'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>


        <script>
        // Autocomplete functionality
        $( function() {
            var artistMatches = [

            ];

            function getRelatedArtists(artistName){ 
                artistMatches = [];
                // use jquery to make calls to the musixmatch api
                $.ajax({
                    type: "GET",
                    data: {
                        // this is our api key
                        apikey:"63ee20957db474cd79ff92b17ce0198c",
                        // this is a variable, which is of a String type
                        q_artist: artistName,
                        format:"jsonp",
                        callback:"jsonp_callback"
                    },
                    // search for track in database
                    url: "http://api.musixmatch.com/ws/1.1/artist.search",
                    dataType: "jsonp",
                    jsonpCallback: 'jsonp_callback',
                    contentType: 'application/json',
                    // upon query success, execute this code:
                    success: function(data) {
                        // for debugging
                        //value = artist name
                        //image = twitter link + "/profile_image?size=mini";
                        for (i = 0; i < data.message.body.artist_list.length; i++) {
                            if (i <= 100) {
                                if (!isEmpty(data.message.body.artist_list[i].artist.artist_name)) {
                                    var name =  data.message.body.artist_list[i].artist.artist_name;
                                    var twitter = data.message.body.artist_list[i].artist.artist_twitter_url;
                                    if (isEmpty(twitter)) {
                                        twitter = 'http://capletonmusic.com/news/wp-content/uploads/2015/11/itunes.png';
                                    } else {
                                        twitter = twitter.substring(20);
                                        twitter = 'http://avatars.io/twitter/' + twitter + '/small';
                                    }
                                    artistMatches.push( {
                                        value: name,
                                        image: twitter
                                        
                                    });
                                    
console.log(name);
console.log(twitter);

                                }
                                    
                                else if (!isEmpty(data.message.body.artist_list[i].artist.artist_twitter_url)) {
                                    var name = data.message.body.artist_list[i].artist.artist_name;
                                    var twitter = data.message.body.artist_list[i].artist.artist_twitter_url;
                                    twitter = 'http://avatars.io/twitter/' + twitter + '/small';

console.log(name);
console.log(twitter);


                                    artistMatches.push({
                                        value: name,
                                        image: twitter
                                    });
                                }
                            }
                        }
                    },
                    // this is what happens when the query is invalid
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }    
                });
            }
            function isEmpty(val){
                return (val === undefined || val == null || val.length <= 0) ? true : false;
            }

            $( ".tags" ).autocomplete({
                minLength: 3,
                source: function( request, response ) {
                    var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                    response( $.grep( artistMatches, function( item ){
                        return matcher.test( item.value );
                    }) );
                }
            }).data("uiAutocomplete")._renderItem = function (ul, item) {
                    return $("<li />")
                        .data("item.autocomplete", item)
                        .append("<a><img src='" + item.image + "' />" + item.value + "</a>")
                        .appendTo(ul);
            };
            $( ".tags" ).keyup(function(){
                if($(this).val().length >= 3) {
                    // update autocomplete matches
                    console.log("updating matches");
                    //artistMatches = [{value: "John Legend",image:"http://capletonmusic.com/news/wp-content/uploads/2015/11/itunes.png"}]
                    getRelatedArtists($(this).val());
                }
            });
        } );
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            input, button {
                font-family:Arial, Helvetica, sans-serif;
                font-size: 120%;
            }

            body {
                background-color: gray;
                font-size: 120%;
                font-family:Arial, Helvetica, sans-serif;

                margin-top:auto;

                text-align: center;
            }

            #searchTextBox {
                border-style: solid;
                border-width: 4px;
                border-color: mediumpurple;

                margin: auto;

                display: block;
            }

            button {
                background-color: mediumpurple;
                color: black;
                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom:auto;
            }

            #canvas-wrap { 
                position:relative; 
                width:500px; 
                height:300px; 
                background-color: white; 
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">

                <div id="screenshotTarget">

                    <div id="canvas-wrap">
                        <div id="wordcloud"></div>
                    </div>
                    
                    <h2>{{$data['artist_name']}}</h2>
                </div>
        {{ Form::open(array('route' => 'form', 'method'=>'post', 'id'=>'myArr')) }}
            {{ $name = Form::input('artist_name', 'artist_name', null, ['class' => 'tags']) }}
            {{ Form::submit('Search') }}
        {{ Form::close() }}

                <div class="controls">
                    <form>
                        <button id="addToCloudButton" onclick="addToCloud()">Add to Cloud</button>
                        <button id="shareToFBButton">Share to Facebook</button>
                    </form>
                </div>

            </div>
        </div>

        <script>
            var arrayOfWords = [];

            function reformat() {

                var string = {!! json_encode($data['word_map']) !!};

                var artist_name = {!! json_encode($data['artist_name']) !!};

                var matchesArray = string.match(/".*?".\d+/gi);

                for (var i = 0; i < matchesArray.length; i++) {
                    var stringVar = matchesArray[i].match(/[a-z][a-z]+/gi) + ''; // modifiers: gi
                    console.log(stringVar);
                    var intVar = parseInt(matchesArray[i].match(/\d+/));
                    console.log(intVar);

                    arrayOfWords.push({
                        text: stringVar,
                        size: intVar,
                        href: 'http://127.0.0.1:8000/song/' + artist_name + '/' + stringVar + '/' + '00'
                    });

                    console.log('your href is: ' + arrayOfWords[i].href);
                }

                console.log(arrayOfWords);
            }


            reformat();

            d3.wordcloud()
                .size([500, 300])
                .words(arrayOfWords)
                .spiral("rectangular")
                .start();

    (function () {

        $('#shareToFBButton').click(function () {
            html2canvas(document.getElementById("screenshotTarget"), {
                onrendered: function(canvas) {
                    // Canvas
                    console.log("rendered");
                    canvas.id = "myCloudCanvas";
                    document.body.appendChild(canvas);

                    // load image from data url
                    var imageObj = new Image();
                    imageObj.onload = function () {
                        ctx.drawImage(this, 0, 0);
                    };

                    var data = $('#myCloudCanvas')[0].toDataURL("image/png");
            try {
                blob = dataURItoBlob(data);
            } catch (e) {
                console.log(e);
            }
            FB.getLoginStatus(function (response) {
                console.log(response);
                if (response.status === "connected") {
                    postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, "http://localhost:8000", "Artist");
                } else if (response.status === "not_authorized") {
                    FB.login(function (response) {
                        postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, "http://localhost:8000", "Artist");
                    }, {scope: "publish_actions"});
                } else {
                    FB.login(function (response) {
                        postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, "http://localhost:8000", "Artist");
                    }, {scope: "publish_actions"});
                }
            });
            var element = document.getElementById("myCloudCanvas");
            document.body.removeChild(element);

                imageObj.src = 'wordcloud.png';
                },
                width: 500,
                height: 370
            });
        });

        function postImageToFacebook(token, filename, mimeType, imageData, message) {
            var fd = new FormData();
            fd.append("access_token", token);
            fd.append("source", imageData);
            fd.append("no_story", true);
            // Upload image to facebook without story(post to feed)
            $.ajax({
                url: "https://graph.facebook.com/me/photos?access_token=" + token,
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    console.log("success: ", data);
                    // Get image source url
                    FB.api(
                        "/" + data.id + "?fields=images",
                        function (response) {
                            if (response && !response.error) {
                                //console.log(response.images[0].source);
                                // Create facebook post using image
                                FB.api(
                                    "/me/feed",
                                    "POST",
                                    {
                                        "message": "",
                                        "picture": response.images[0].source,
                                        "link": "localhost:8000",
                                        "name": 'Check out my word cloud!',
                                        "description": message,
                                        "privacy": {
                                            value: 'SELF'
                                        }
                                    },
                                    function (response) {
                                        if (response && !response.error) {
                                            /* handle the result */
                                            console.log("Posted story to facebook");
                                            console.log(response);
                                        }
                                    }
                                );
                            }
                        }
                    );
                },
                error: function (shr, status, data) {
                    console.log("error " + data + " Status " + shr.status);
                },
                complete: function (data) {
                    //console.log('Post to facebook Complete');
                }
            });
        }
        function dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], {type: 'image/png'});
        }
    })();

    </script>
    </body>
</html>
