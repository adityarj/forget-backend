<?php
/**
 * Created by PhpStorm.
 * User: HP-PC
 * Date: 27-11-2016
 * Time: 14:53
 */

namespace App\Providers;


use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Foundation\Application;

class GoogleServiceProvider
{
    protected $client;
    protected $service;

    function __construct(Application $app)
    {
        $client_id = Config::get('Google.client_id');
        $service_account_name = Config::get('Google.service_account_name');
        $key = Config::get('Google.api_key');

        $this->client = new \Google_Client();
        $this->client->setApplicationName("your_app_name");
        $this->service = new \Google_Service_Books($this->client);

    }

    public function getTextForSound() {
        $results = $this->service->volumes->listVolumes("Henry David Thoreau");
        return $results;
    }
}