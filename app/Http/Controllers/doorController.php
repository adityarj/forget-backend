<?php

namespace App\Http\Controllers;

use App\doorStatus;
use Illuminate\Http\Request;

class doorController extends Controller
{
    //Function to handle door change, call when
    public function handleDoorChange(Request $request) {
        $door = doorStatus::where('compartment','=','comp1');
        $door->status = $request->get('status');
        $door->save();

        $result['result'] = 'success';

        return json_encode($result);
    }

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

    public function addDoorEntry() {
        $door = new doorStatus();
        $door->compartment = 'comp1';
        $door->save();

        return json_encode($door);
    }

    public function getDoorEntry() {
        $door = doorStatus::all();
        return json_encode($door);
    }

    public function resetEntry() {
        doorStatus::truncate();
        $result['result'] = 'success';
        return $result;
    }
}
