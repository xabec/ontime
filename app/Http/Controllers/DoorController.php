<?php

namespace App\Http\Controllers;

use App\Models\Door;
use Illuminate\Http\Request;
use stdClass;


class DoorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('doors');
    }

    function my_encrypt($data, $passphrase) {
        $secret_key = hex2bin($passphrase);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted_64 = openssl_encrypt($data, 'aes-256-cbc', $secret_key, 0, $iv);
        $iv_64 = base64_encode($iv);
        $json = new stdClass();
        $json->iv = $iv_64;
        $json->data = $encrypted_64;
        return base64_encode(json_encode($json));
    }

    function open() {

        $key = '3e4fa62891d19feacd7f1234d558a752251fe4005f821469052e05e890e99d30';

        $this->validate(request(), [
            'doors' => 'required|numeric'
        ]);

        $id = request('doors');


        try {
            $doors = Door::findOrFail($id);

            $encoded = $this->my_encrypt($doors->door_id, $key);


            $fp = fsockopen($doors->ip, $doors->port, $errno, $errstr, 30);

            if (!$fp) {
                echo "$errstr ($errno)<br />\n";
            } else {
                fwrite($fp, $encoded);
                $output = fread($fp, 2);
            }
        } catch (\Exception $e) {
            return ['success' => false];
        }

        return ['success' => $output === 'OK'];
    }

}

