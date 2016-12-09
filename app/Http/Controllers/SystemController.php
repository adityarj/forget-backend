<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class SystemController extends Controller
{
    public function openDoor() {

    }

    //Below api is for when a negative weight is posted by the system
    public function getItemByWeight(Request $request) {

        $weight = abs($request->get('weight'));

        $item = Item::where('weight','>=',$weight - 0.5)
            ->where('weight','<=',$weight + 0.5)
            ->get();

//        if ($item) {
//            return json_encode($item);
//        } else {
//            return null;
//        }

        $data['status'] = 'success';
        return json_encode($data);

    }

    //Below api is for when a  positive weight is posted by the system
    public function handleWeight(Request $request) {

        $item_original =  Item::where('weight',0)->get();


            $item = new Item();
            $item->weight = $request->get('weight');
            $item->item = "none";
            $item->bin = 0;
            $item->save();


        $data['status'] = 'success';
        return json_encode($data);


    }

    public function handleDoorClose(Request $request) {
        //send push notification
        if ($request->get('closed')) {
            $data['status'] = 'success';
            return json_encode($data);
        } else {
            $data['status'] = 'failed';
            return json_encode($data);
        }

     }

     public function transmitSignal() {

        $appRequestSuccess = true;

        if ($appRequestSuccess) {
            $data['status'] = true;
            return json_encode($data);
        }
     }
}
