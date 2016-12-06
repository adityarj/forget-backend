<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function handleItem(Request $request) {

        $item = new Item();
        $item->item = $request->get('item');
        $item->bin = $request->get('bin');
        $item->weight = 0;
        $item->save();

    }

    public function removeItem(Request $request) {

        $item = Item::where('item',$request->get('item'))->get();

        if ($item[0]) {
            Item::were('item',$request->get('item'))->delete();
            return json_encode($item);
        } else {
            $error['Error'] = 'Item not found';
            return json_encode($error);
        }

    }

    public function getItems() {

        $item = Item::all();
        return json_encode($item);

    }

    public function completeItem(Request $request) {

        $item = Item::where('item','=',null)->get();
        $item->item = $request->get('item');
        $item->bin = $request->get('bin');
        $item->save();

    }

    public function resetItems(Request $request) {

        Item::truncate();

        $data['result'] = 'sucess';
        return $data;
    }
}
