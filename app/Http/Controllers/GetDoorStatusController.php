<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetDoorStatusController extends Controller
{
    public $status = ''; public $id = '';

    public function status(Request $request)
    {
        $this->id = $request->id;
        $this->status = $request->status;
        Log::info('Received the message');
        echo($this->status);
        echo($this->id);
        echo(json_encode(["status" => "success"]));
    }



}
