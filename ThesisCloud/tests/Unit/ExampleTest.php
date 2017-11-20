<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    public function testWelcomePage()
    {
        $response = $this->call('GET', '/', []);
        $this->assertEquals(200, $response->status());
    }
    public function testSongCloudAppearsOnWelcomePage()
    {
        $response = $this->call('GET', '/', []);
        $songcloud = strval($response);
        $this->assertContains('SongCloud', $songcloud);
    }
    public function testCloudStatus()
    {
        $response = $this->call('GET', '/cloud/Kanye West/word/00', []);
        $this->assertEquals(200, $response->status());
    }
    public function testCloudArtistName()
    {
        $response = $this->call('GET', '/cloud/Kanye West/word/00');
        $artistname = strval($response);
        $this->assertContains('Kanye West', $artistname);
    }
}