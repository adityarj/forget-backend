<?php

namespace App\Http\Controllers;

use App\doorStatus;
use App\Item;
use App\activeItem;
use App\activeLED;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;


class doorController extends Controller
{
    //Function to handle door change, call when the door is open or closed
    public function handleDoorChange(Request $request) {

        $door = doorStatus::first();
        $door->status = $request->get('status');
        $door->save();

        $result['result'] = 'success';

        return json_encode($result);
    }

    //Function to get the current door status, call when the door status is desired
    public function getDoorStatus(Request $request) {

        $door = doorStatus::first();
        $status = $door->status;
        if($status == 0) {
            $result['status'] = 'closed';
        } else {
            $result['status'] = 'open';
        }

        return json_encode($result);

    }

    public function handleArduinoCode(Request $request) {

        $weight = $request->get('weight');

        if ($weight == 0) {

        } else if($weight < 0) {
            $item = Item::where('weight','>=',$weight - 8)
                ->orWhere('weight','<=',$weight + 8)
                ->first();

            if ($item) {

                $active = activeItem::first();
                $active->item = $item->item;
                $active->change = -1;
                $active->save();

            } else {

                $active = activeItem::first();
                $active->item = "Cannot identify";
                $active->change = -1;
                $active->save();

            }
        } else {
            $item_original =  Item::where('weight',0)->get();

            if (!$item_original->isEmpty()) {
                $item_new_value = Item::where('weight',0)->first();
                $item_new_value->weight = $request->get('weight');
                $item_new_value->save();


            } else {
                $item = new Item();
                $item->weight = $request->get('weight');
                $item->item = "none";
                $item->bin = 0;
                $item->save();

                $active = activeItem::first();
                $active->item = $item->item;
                $active->change = 1;
                $active->save();

            }
        }

        $door = doorStatus::first();
        $door->status = $request->get('status');
        $door->save();

        $led = activeLED::first();
        if ($led->light == 1) {
            $return = 1;
        } else {
            $return = 0;
        }
        $result['result'] = $return;
        return json_encode($result);
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
