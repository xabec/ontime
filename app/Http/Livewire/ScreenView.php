<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\DoorDisplay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class ScreenView extends Component
{
    public $thisdoordisplay = ''; public $thisdoctor = ''; public $status = ''; public $door_id = '';

    public function render()
    {
        $doordisplays = DoorDisplay::select('*')->get();
        $doctors = User::where('account_rank', '=', '1')->get();
        $selecteddisplay = DoorDisplay::where('id', '=', $this->thisdoordisplay)->first();
        $selecteddoctoruser = User::where('id', '=', $this->thisdoctor)->first();
        $selecteddoctor = Doctor::where('user_id', '=', $this->thisdoctor)->first();

        return view('livewire.screenview', [
            'doordisplays' => $doordisplays,
            'doctors' => $doctors,
            'selecteddisplay' => $selecteddisplay,
            'selecteddoctoruser' => $selecteddoctoruser,
            'selecteddoctor' => $selecteddoctor
        ]);
    }

    public function changestatus(Request $request)
    {

        $this->door_id = $request->id;
        $this->status = $request->status;
        $data['status'] = $request->status;
        $selecteddisplay = DoorDisplay::where('doors_id', '=', $this->door_id)->update($data);
    }
}
