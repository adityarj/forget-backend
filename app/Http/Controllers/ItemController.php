<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function handleItem(Request $request) {

        $item = new Item();
        $item->item = $request->get('item');
        $item->id = $request->get('id');
        $item->weight = $request->get('weight');
        $item->save();

    }

    public function removeItem(Request $request) {

        $item = Item::where('item',$request->get('item'))->get();

        if ($item) {
            Item::where('item',$request->get('item'))->delete();
        } else {
            $error['Error'] = 'Item not found';
            return $error;
        }

    }

    public function getItems(Request $request) {
        $item = Item::all();
        return json_encode($item);
    }

    public function getItemByWeight(Request $request) {

    }

    public function handleWeight(Request $request) {

        $item = new Item();
        $item->weight = $request->get('weight');
        $item->save();

        //Pass id to app to let user enter data

    }
}
