<?php

namespace App\Http\Controllers;

use App\Providers\GoogleServiceProvider;
use Illuminate\Http\Request;


class randomTests extends Controller

{
    public function speechClientTest(GoogleServiceProvider $googleServiceProvider) {
        $results  = $googleServiceProvider->getTextForSound();
        return json_encode($results);
    }
}
