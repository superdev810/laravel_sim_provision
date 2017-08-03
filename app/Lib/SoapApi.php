<?php
namespace App\Lib;

use Exception;
use SoapClient;

class SoapApi
{

    public $url = null;
    public $client = null;

    public function __construct($url, $trace = true)
    {
        $this->url = $url;
        $this->client = new SoapClient($url, Array('trace' => $trace));
    }

    public function registerMSISDN($user, $info) {
        try
        {
            return $this->client->registerMSISDN(Array('user' => $user, 'info' => $info));
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }


    }


}