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
        $this->client->setDeveloperKey($key);
        $this->client->setClientId($client_id);
        $this->client->setApplicationName("forget-backend");
        $this->service = new \Google_Service_Speech($this->client);

    }

    public function getTextForSound() {


        $config = new \Google_Service_Speech_RecognitionConfig();
        $config->setEncoding("FLAC");
        $config->setLanguageCode("en-US");
        $config->setSampleRate(8000);

        $file = fopen(public_path('/sounds/hello.flac'),"rb") or die("Unable to open file");

        $object = new \Google_Service_Speech_RecognitionAudio();
        $object->setContent($file);

        $async = new \Google_Service_Speech_SyncRecognizeRequest();

        $async->setConfig($config);
        $async->setAudio($object);

        $results = $this->service->speech->syncrecognize($async);
        return $results;
    }
}