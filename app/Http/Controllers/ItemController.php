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

        $data['success'] = 'true';
        return json_encode($data);

    }

    public function removeItem(Request $request) {

        $item = Item::where('item',$request->get('item'))->get();

        if (!$item->isEmpty()) {
            $result['Delete'] = 'Success';
            Item::where('item',$request->get('item'))->delete();
            return json_encode($result);
        } else {
            $error['Error'] = 'Item not found';
            return json_encode($error);
        }

    }

    public function checkItem(Request $request) {

       $item = Item::where('item',$request->get('item'))->get();
       if(!$item->isEmpty()) {
           return json_encode($item);
       } else {
           $error['Error'] = 'Item not found';
           return json_encode($request->get('item'));
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

        $data['completed'] = 'true';
        return json_encode($data);

    }

    public function resetItems(Request $request) {

        Item::truncate();

        $data['result'] = 'Success';
        return json_encode($data);
    }
}
