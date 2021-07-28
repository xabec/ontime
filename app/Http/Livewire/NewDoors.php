<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use stdClass;

class NewDoors extends Component
{

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

    public function check()
    {
        $key = '3e4fa62891d19feacd7f1234d558a752251fe4005f821469052e05e890e99d30';

        $ip = request('ip');
        $port = request('port');
        $check_status = '0'; // 0 means status check on raspberry, other numbers are for specific doors

        try {
            $encoded = $this->my_encrypt($check_status, $key);
            $fp = fsockopen($ip, $port, $errno, $errstr, 30);
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

    public function render()
    {
        $id = Auth::id();
        return view('livewire.backstage.newdoors', [$id]);
    }
}
