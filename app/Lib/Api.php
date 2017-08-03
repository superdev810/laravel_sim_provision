<?php
namespace App\Lib;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: atik
 * Date: 11/24/16
 * Time: 3:57 PM
 */
class Api
{
    public $client;

    public function __construct($baseUrl = '')
    {
        $this->client = new Client(['base_uri' => $baseUrl]);
    }

    public function get($subUrl)
    {
        $response = $this->client->request('GET', $subUrl);

        if($response->getStatusCode() == 200) {

            $body = $response->getBody();

            return [
                'message' => (string) $body,
                'success' => true
            ];

        } else {
            return [];
        }
    }


    public function post($subUrl, $data)
    {
        $response = $this->client->request('POST', $subUrl, $data);

        if($response->getStatusCode() == 200) {

            $body = $response->getBody();

            return [
                'message' => (string) $body,
                'success' => true
            ];

        } else {
            return [];
        }
    }
}