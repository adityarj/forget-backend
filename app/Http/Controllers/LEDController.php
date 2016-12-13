<?php

namespace App\Http\Controllers;

use App\activeLED;
use Illuminate\Http\Request;

class LEDController extends Controller
{
    //Set the LED as on/off for each compartment
    public function setLED(Request $request) {
        $led = activeLED::first();
        $led->light = $request->get('led');
        $led->save();

        $result['result'] = 'success';
        return json_encode($result);
    }

    //Get the current status of the LED
    public function getLEDStatus() {
        $led = activeLED::first();
        if ($led->light == 1) {
            $return['status'] = 'on';
        } else {
            $return['status'] = 'off';
        }
        return json_encode($return);
    }

    //Add a new LED entry, admin use only
    public function addLEDEntry() {
        $led = new activeLED();
        $led->bin = "comp1";
        $led->light = false;
        $led->save();

        $result['result'] = 'success';
        return json_encode($result);
    }

    //Fetch all active LED controllers, admin use only
    public function fetchLEDEntry() {
        $led = activeLED::all();
        return json_encode($led);
    }

    //Reset the LED roster
    public function reset() {
        activeLED::truncate();

        $result['result'] = 'success';
        return json_encode($result);
    }
}
