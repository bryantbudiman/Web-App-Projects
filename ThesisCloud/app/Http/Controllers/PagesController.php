<?php
namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Redirect;
use Illuminate\Support\Facades\Input;

class PagesController extends Controller {

    // DO NOT DELETE: THIS IS FOR REFERENCE
    // public function example() {

    //     return view('song', [
    //         'songs' => ['one', 'two', 'three'],

    //         'test' => 'test value',

    //         'hasharray' => [
    //             "IT" => "IT value",
    //             "she" => "she value",
    //             "he"=> "he value",
    //             "they"=> "they value",
    //             "about" => "about value",
    //         ]

    //         ]);
    // }

    public function getCloudFrequencyMap($view, $artist_name, $word)
    {
        //print('$first_artist_data:' . $first_artist_data);

        $filler_words = [
            "IT" => 1,
            "she" => 1,
            "he"=> 1,
            "they"=> 1,
            "about" => 1,
            "\0" => 1,
            "below" => 1,
            "excepting" => 1,
            "off" => 1,
            "toward" => 1,
            "above" => 1,
            "beneath" => 1,
            "for" => 1,   
            "on" => 1,
            "under" => 1,
            "across" => 1,
            "besides" => 1,
            "from" => 1,
            "onto" => 1,    
            "underneath" => 1,
            "after" => 1,
            "between" => 1,    
            "in" => 1,
            "out" => 1,
            "until" => 1,
            "against" => 1,    
            "beyond" => 1,    
            "outside" => 1,
            "up" => 1,
            "along" => 1,
            "but" => 1,
            "inside" => 1,
            "over" => 1,
            "upon" => 1,
            "among" => 1,
            "by" => 1,    
            "past" => 1,
            "around" => 1,
            "concerning" => 1,
            "instead" => 1,
            "regarding" => 1,
            "with" => 1,
            "at" => 1,
            "despite" => 1,
            "into" => 1,
            "since" => 1,
            "within" => 1,
            "because" => 1,
            "down" => 1,
            "like" => 1,
            "through" => 1,
            "without" => 1,
            "before" => 1,
            "during" => 1,
            "near" => 1,
            "throughout" => 1,
            "behind" => 1,
            "except" => 1,
            "of" => 1,
            "to" => 1,
            "or" => 1,
            "if" =>1
        ];

        $musixmatch_api_key = "d60e5a5c7aff26124d2f182cd3bd2dc5";

        $musixmatch = new Musixmatch($musixmatch_api_key);
        
        $result = $musixmatch->method('track.search', array(
            'q_artist'  => $artist_name,
            'page_size' => '20'
        ));

        $track_array = $result['message']['body']['track_list'];

        $word_map = array();
        $word_song_freq_map = array();

        foreach($track_array as $track) 
        {
            $track_body_result = $musixmatch->method('track.lyrics.get', array(
                'track_id' => $track['track']['track_id']
            ));

            $track_body = $track_body_result['message']['body']['lyrics']['lyrics_body'];
            $track_body = strtoupper($track_body);
            $track_body = substr($track_body, 0, -75);
            $track_body = str_replace(',', "", $track_body);
            $track_body = str_replace('.', "", $track_body);
            $track_body = str_replace('"', "", $track_body);


            $track_name = $track['track']['track_name'];
            $track_name = strtoupper($track_name);

            $track_body_list = preg_split("/\n|\s/", $track_body);

            foreach($track_body_list as $word_token)
            {
                $word_token = trim($word_token);
                if (!array_key_exists($word_token, $filler_words))
                {
                    if(array_key_exists($word_token, $word_map))
                    {
                        $word_map[$word_token] += 1;
                    }
                    else if (!empty($word_token))
                    {
                        $word_map[$word_token] = 1;
                    }
                }
                if(array_key_exists($word_token, $word_song_freq_map))
                {
                    if(array_key_exists($track_name, $word_song_freq_map[$word_token]))
                    {
                        $word_song_freq_map[$word_token][$track_name] += 1;
                        arsort($word_song_freq_map[$word_token]);
                    }
                    else
                    {
                        $word_song_freq_map[$word_token][$track_name] = 1;
                    }
                }
                else
                {
                    $word_song_freq_map[$word_token][$track_name] = 1;
                }                       
            }
        }

        $word_map = json_encode($word_map);

        // if($first_artist_data != '00') {
        //     print('$first_artist_data != 00') {
        //         $data['first_artist_data'] = $first_artist_data;
        //     }
        // }

        $data['word_map'] = $word_map;
        $data['artist_name'] = $artist_name;
        $data['word_song_freq_map'] = $word_song_freq_map;
        $data['word'] = $word;

        // this is how to pass an array to the view
        return view($view, ['data' => $data]);
        //return view('song', ['word_map' => $word_song_freq_map[$word]]);
    }

    // public function getTracksNameArrayFromWord($q_artist, $q_lyrics) {
    //     $musixmatch_api_key = "d60e5a5c7aff26124d2f182cd3bd2dc5";
    //     $musixmatch = new Musixmatch($musixmatch_api_key);

    //     $result = $musixmatch->method('track.search', array(
    //         'q_artist'  => $q_artist, 
    //         'q_lyrics' => $q_lyrics 
    //     ));

    //     $track_name_array = 
    //         $result['message']['body']['track_list'];
            
    //         // //echo $track_id_array for test purposes
    //         // echo('###ECHO OF $tracks_id_array###');
    //         // foreach($track_name_array as $track_list) {
    //         //     echo($track_list['track']['track_name'] . ",");
    //         // }
    //         // echo('###END OF ECHO###');

    //     return view('song')->with('track_name_array', $track_name_array);
    // }

    public function getSongLyrics($q_track, $q_lyrics) {
        $word = $q_lyrics;
        $songtitle = $q_track;

        //echo("getSongLyrics called with song : " . $songtitle . " word : " . $q_lyrics);

        $musixmatch_api_key = "d60e5a5c7aff26124d2f182cd3bd2dc5";
        $musixmatch = new Musixmatch($musixmatch_api_key);

        $result = $musixmatch->method('track.search', array(
            // 'q_artist' => $q_artist,
            'q_track'  => $q_track, 
        ));

        $track_id = 
            $result['message']['body']['track_list'][0]['track']['track_id'];

        //print($track_id);

        $result = $musixmatch->method('track.lyrics.get', array(
            'track_id'  => $track_id, 
        ));

        $lyrics =
            $result['message']['body']['lyrics']['lyrics_body'];

        //print($song);

        return view('lyrics', ['data' => [$word, $songtitle, $lyrics]]);
    }

    public function startPage()
    {
        return view('welcome');
    }

    public function postArtistNameToCloudPage()
    {
        return Redirect::route('cloud', ['view' => 'cloud', 'artist_name' => Input::get('artist_name'), 'word' => 'word', 'first_artist_data' => '00']);
    }


    // public function view2($artist_name)
    // {
    //     // return View::make('view2')->with('name',$name);
    //     return view('cloud')->with('artist_name', $artist_name);
    // }

}