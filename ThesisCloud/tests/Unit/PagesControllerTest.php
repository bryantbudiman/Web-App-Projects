<?php

namespace App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesControllerTest extends TestCase
{

    public function testGetCloudFrequencyMapForCloud()
    {
        $controller = new PagesController();
        $func = "getCloudFrequencyMap";
        $view = "cloud";
        $artist_name = "Taylor Swift";
        $word = "word";
        $response = $controller->$func($view, $artist_name, $word);
        $stringResponse = strval($response);
        $this->assertContains('postImageToFacebook(', $stringResponse); // method only found in cloud
    }

    public function testGetSongLyrics()
    {
        $controller = new PagesController();
        $func = "getSongLyrics";
        $track = "NIGHT CHANGES";
        $lyrics = "MOTHER";
        $response = $controller->$func($track, $lyrics);
        $stringResponse = strval($response);
        $this->assertContains('highlightText()', $stringResponse); // method only found in song
    }

    public function testStartPage() 
    {
        $controller = new PagesController();
        $func = "startPage";
        $response = $controller->$func();
        $stringResponse = strval($response);
        $this->assertContains('Welcome to SongCloud!', $stringResponse); // string only found in welcome
    }

    public function testPostArtistNameToCloudPage()
    {
        $controller = new PagesController();
        $func = "postArtistNameToCloudPage";
        $response = $controller->$func();
        $stringResponse = strval($response);
        $this->assertNotContains('<h2>{{$data', $stringResponse); // test that tag data has been filled in
    }

}
