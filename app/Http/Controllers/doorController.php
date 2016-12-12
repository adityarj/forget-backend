<?php

namespace App\Http\Controllers;

use App\doorStatus;
use Illuminate\Http\Request;

class doorController extends Controller
{
    //Function to handle door change, call when the door is open or closed
    public function handleDoorChange(Request $request) {
        $door = doorStatus::where('compartment','=','comp1');
        $door->status = $request->get('status');
        $door->save();

        $result['result'] = 'success';

        return json_encode($result);
    }

    //Function to get the current door status, call when the door status is desired
    public function getDoorStatus(Request $request) {

        $door = doorStatus::where('compartment','=','comp1');
        $status = $door->status;
        if($status == 'closed') {
            $status['status'] = 'close';
        } else {
            $status['status'] = 'closed';
        }

        return json_encode($status);

    }

    //Maintained for admin purposes, get request when required to add a new entry for new reason [production build will require to have multiple calls]
    public function addDoorEntry() {
        $door = new doorStatus();
        $door->compartment = 'comp1';
        $door->status = false;
        $door->save();

        return json_encode($door);
    }


    //Get all available door entries, for admin purposes only
    public function getDoorEntry() {
        $door = doorStatus::all();
        return json_encode($door);
    }

    //Reset the door table, remove everything
    public function resetEntry() {
        doorStatus::truncate();
        $result['result'] = 'success';
        return $result;
    }
}
