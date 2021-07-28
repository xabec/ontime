<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class FinishRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('auth.finishregistration');
    }
}
