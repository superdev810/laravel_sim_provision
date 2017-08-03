<?php
namespace App\Lib;
/**
 * Created by PhpStorm.
 * User: atik
 * Date: 11/24/16
 * Time: 3:57 PM
 */
class Url
{
    private $baseUrl = "http://54.209.42.84:8182/BulkMailer/";

    public function __construct($baseUrl = '')
    {
        $this->baseUrl = ($baseUrl) ? $baseUrl : $this->baseUrl;
    }

    public function put($subUrl)
    {
        return $this->baseUrl . $subUrl;
    }

    public function getBaseUrl()
    {
      return $this->baseUrl;
    }
}