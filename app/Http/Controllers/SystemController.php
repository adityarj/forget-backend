<?php

namespace App\Http\Controllers;

use App\activeItem;
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

            $active = activeItem::where('bin','=','comp1');
            $active->item = $item->item;
            $active->change = -1;
            $active->save();

            return json_encode($item);
        } else {

            $active = activeItem::where('bin','=','comp1');
            $active->item = "Cannot identify";
            $active->change = -1;
            $active->save();

            $result['result'] = 'item not found';
            return json_encode($result);
        }

    }

    //Below api is for when a  positive weight is posted by the system, update the required table with positive
    public function handleWeight(Request $request) {

        $item_original =  Item::where('weight',0)->get();

        if (!$item_original->isEmpty()) {

            $item_original->weight = $request->get('weight');
            $item_original->save();

        } else {
            $item = new Item();
            $item->weight = $request->get('weight');
            $item->item = "none";
            $item->bin = 0;
            $item->save();

            $active = activeItem::where('bin','=','comp1');
            $active->item = $item->item;
            $active->change = 1;
            $active->save();

        }

        $data['status'] = 'success';
        return json_encode($data);

    }

    //Retrieve the active state
    public function getActive() {
        $active = activeItem::where('bin','=','comp1')->get();
        return json_encode($active);
    }

    //Set the active state to null once a request has been fulfilled
    public function setActiveToNull() {
        $active = activeItem::first();
        $active->item = "null";
        $active->change = 0;
        $active->save();

        $result['result'] = 'success';
        return json_encode($result);
    }

    //Add active record when needed
    public function addActive() {
        $active = new activeItem();
        $active->item = "null";
        $active->bin = "comp1";
        $active->change = 0;
        $active->save();

        return json_encode($active);
    }

    //Show all records if required, for administrative purposes
    public function showAllActive() {
        $active = activeItem::all();
        return json_encode($active);
    }

    //What the hell is this supposed to do, JUST FOR ZOU'S TESTING PURPOSE
    public function transmitSignal() {

        $appRequestSuccess = true;

        if ($appRequestSuccess) {
            $data['status'] = true;
            return json_encode($data);
        }
    }


    //Just for Zou's testing purpose
    public function checkPost(Request $request) {

        $value = $request->get('code');
        $result['result'] = 'You sent a code '.$value;

        return json_encode($result);
    }
}
