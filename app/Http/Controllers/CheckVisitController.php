<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;

class CheckVisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {

        $thisvisit = Visit::where('id', '=', $id)->first();
        $thisdoctor = User::where('id', '=', $thisvisit->doctor_id)->first();
        return view('livewire.backstage.checkvisit', compact('thisvisit', 'thisdoctor'));
    }
}
