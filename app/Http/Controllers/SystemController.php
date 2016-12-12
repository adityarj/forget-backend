<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class SystemController extends Controller
{

    //Below api is for when a negative weight is posted by the system, update the table with negative weight
    public function getItemByWeight(Request $request) {

        $weight = abs($request->get('weight'));

        $item = Item::where('weight','>=',$weight - 0.5)
            ->where('weight','<=',$weight + 0.5)
            ->get();

        if (!$item->isEmpty()) {
            return json_encode($item);
        } else {
            $result['result'] = 'item not found';
            return json_encode($result);
        }

    }

    //Below api is for when a  positive weight is posted by the system, update the required table with positive
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


    //What the hell is this supposed to do, JUST FOR ZOU'S TESTING PURPOSE
    public function transmitSignal() {

        $appRequestSuccess = true;

        if ($appRequestSuccess) {
            $data['status'] = true;
            return json_encode($data);
        }
    }

    public function checkPost(Request $request) {

        $value = $request->get('code');
        $result['result'] = 'You sent a code '.$value;

        return json_encode($result);
    }
}
