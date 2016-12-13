<?php

namespace App\Http\Controllers;

use App\analyticsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class analyticsConroller extends Controller
{
    public function add(Request $request) {

        $time = $request->get('time');

        $maxtime = Carbon::parse($time);
        $maxtime->addMinute();

        $mintime = Carbon::parse($time);
        $mintime->subMinute();

        $use = analyticsModel::where([
            ['date','<=',$maxtime],
            ['date','>=',$mintime]])->first();
        if(!$use->isEmpty()) {
            $use->counter = $use->counter + 1;
            $use->save();

            $result['result'] = $use->counter;
            return json_encode($result);
        } else {
            $new_use = new analyticsModel();
            $new_use->time = $request->get('time');
            $new_use->counter = 1;
            $new_use->save();

            return json_encode($new_use);
        }

    }

    public function getAll() {
        $time = analyticsModel::all();
        return json_encode($time);
    }
}
