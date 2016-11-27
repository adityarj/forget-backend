<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Speech\SpeechClient;

class randomTests extends Controller
{
    public function speechClientTest() {

    	$speech = new SpeechClient();

    	$text['error'] = false;
    	return $text;

    }
}
