<?php

namespace App\Http\Controllers;

use App\analyticsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class analyticsConroller extends Controller
{
    public function add(Request $request) {

        $time = $request->get('date');


        $use = analyticsModel::where('date','=',Carbon::parse($time)->format("YYYY-MM-DD"))->first();
        if($use) {
            $use->counter = $use->counter + 1;
            $use->save();

            $result['result'] = $use->counter;
            return json_encode($result);
        } else {
            $new_use = new analyticsModel();
            $new_use->date = $request->get('date');
            $new_use->counter = 1;
            $new_use->save();

            return json_encode(Carbon::parse($time)->format("YYYY-MM-DD"));
        }

    }

    public function getAll() {
        $time = analyticsModel::all();
        return json_encode($time);
    }
}
