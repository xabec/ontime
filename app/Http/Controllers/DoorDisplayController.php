<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\DoorDisplay as displayinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DoorDisplayController extends Controller
{
    public function insert(Request $request, $id)
    {
        $validator = Validator::make(
            [
                'name' => $request->input('name'),
                'cabinet_number' => $request->input('cabinet_number')
            ],
            [
                'name' => 'required|max:255',
                'cabinet_number' => 'required|max:5'
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            if(!empty(displayinfo::where('doors_id', '=', $id)->first()))
            {
                $appendableData = $request->all();
                //pašaliname iš masyvo saugumui naudojamą _token kintamąjį
                unset($appendableData ['_token']);

                $newdisplayinfo = displayinfo::where('doors_id','=',$id)->update($appendableData);
            }
            else
            {
                $displayinfo = new displayinfo();
                $displayinfo->name = $request->input('name');
                $displayinfo->cabinet_number = $request->input('cabinet_number');
                $displayinfo->status = '0';
                $displayinfo->doors_id = $id;

                $displayinfo->save();
            }
        }
        return Redirect::to('/doors')->with('success', 'Durų ekrano informacija atnaujinta');
    }

    public function index($id)
    {
        $displayinfo = displayinfo::where('doors_id', '=', $id)->get()->first();
        $doors = Door::where('id', '=', $id)->get()->first();
        return view('doordisplay', compact('displayinfo', 'doors'));
    }
}
