<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Cache\CacheSubscriber;
use GuzzleHttp\Subscriber\Cache\CacheStorage;
use GuzzleHttp\Subscriber\Cache\DefaultCacheStorage;

class Musixmatch {
    public static $STATUS_CODES = array(
        200=>'The request was successful',
        400=>'The request had bad syntax or was inherently impossible to be satisfied',
        401=>'authentication failed, probably because of a bad API key',
        402=>'a limit was reached, either you exceeded per hour requests limits or your balance is insufficient.',
        403=>'You are not authorized to perform this operation / the api version you’re trying to use has been shut down.',
        404=>'requested resource was not found',
        405=>'requested method was not found',
    );
    private $apiVersion = 1.1;
    private $client;
    private $defaultParams = array();
    public $response;
    function __construct($apiKey, $cacheDir = false, $cacheLength = 3600) {
        $this->defaultParams = array(
            'apikey' => $apiKey,
            'format' => 'json'
        );
        $this->client = new Client([
            'base_uri' => sprintf('http://api.musixmatch.com/ws/%s/', $this->apiVersion)
        ]);
        if ($cacheDir !== false) {
            $storage = new CacheStorage(
                //new FilesystemCache($cacheDir), '.musix', $cacheLength
            );
            CacheSubscriber::attach($this->client, array(
                'storage' => $storage,
            ));
        }
    }
    public function method($methodName, $params = array()) {
        $query_params = http_build_query(array_merge($this->defaultParams, $params));
        $this->response = $this->client->request('GET', $methodName."?".$query_params);
        $data = (string)$this->response->getBody();
        if (!$data) {
            return false;
        }
        $data = json_decode($data, true);
        // return $data['message']['body'];
        return $data;

    }
}
?>