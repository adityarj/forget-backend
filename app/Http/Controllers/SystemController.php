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

        $item = Item::where('weight','>=',$request->get('weight') - 0.5)
            ->where('weight','<=',$request->get('weight') + 0.5)
            ->get();

        if ($item) {
            return json_encode($item);
        } else {
            return null;
        }

    }

    //Below api is for when a  positive weight is posted by the system
    public function handleWeight(Request $request) {

        $item_original =  Item::where('weight',null)->get();

        if ($item_original) {
            $item_original->weight = $request->get('weight');
        } else {
            $item = new Item();
            $item->weight = $request->get('weight');
            $item->save();
        }


    }
}
