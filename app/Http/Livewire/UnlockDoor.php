<?php

namespace App\Http\Livewire;

use App\Models\Door;
use App\Models\DoorDisplay;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Livewire\Component;
use stdClass;

class UnlockDoor extends Component
{

    public $unlock_code = '';

    public function render()
    {
        return view('livewire.backstage.unlockdoor');
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

    function open_public(Request $request)
    {
        $timebefore = Carbon::now()->setTimezone(3)->subMinutes(30);
        $timeafter = Carbon::now()->setTimezone(3)->addMinutes(30);

        $visit = Visit::where('unlock_id', '=', $request->input('unlock_id'))
            ->whereBetween('visit_date', [$timebefore, $timeafter])
            ->first();

        $key = '3e4fa62891d19feacd7f1234d558a752251fe4005f821469052e05e890e99d30';

        if (!empty($visit))
        {

            if ($visit->status == 1)
            {
                return redirect()->back()->with('error', 'Kodas panaudotas');
            }

            $doors = Door::where('id', '=', $visit->doors_id)->first();
            $visitdata['status'] = 1;
            $visitupdate = Visit::where('unlock_id', '=', $request->input('unlock_id'))
                ->whereBetween('visit_date', [$timebefore, $timeafter])->update($visitdata);
            $data['status'] = 1;
            $doordisplay = DoorDisplay::where('doors_id', '=', $visit->doors_id)->update($data);
            try {
                $encoded = $this->my_encrypt($doors->door_id, $key);

                $fp = fsockopen($doors->ip, $doors->port, $errno, $errstr, 30);

                if (!$fp) {
                    echo "$errstr ($errno)<br />\n";
                } else {
                    fwrite($fp, $encoded);
                    $output = fread($fp, 2);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Durys neatsako');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Neteisingas kodas');
        }

        return view('close');
    }

    function open_public_link(Request $request)
    {
        $timebefore = Carbon::now()->setTimezone(3)->subMinutes(30);
        $timeafter = Carbon::now()->setTimezone(3)->addMinutes(30);

        $this->unlock_code = $request->unlock_id;


        echo($this->unlock_code);
        $visit = Visit::where('unlock_id', '=', $this->unlock_code)
            ->whereBetween('visit_date', [$timebefore, $timeafter])
            ->first();

        $key = '3e4fa62891d19feacd7f1234d558a752251fe4005f821469052e05e890e99d30';

        if (!empty($visit))
        {

            if ($visit->status == 1)
            {
                return redirect()->back()->with('error', 'Kodas panaudotas');
            }

            $visitdata['status'] = 1;
            $visitupdate = Visit::where('unlock_id', '=', $request->input('unlock_id'))
                ->whereBetween('visit_date', [$timebefore, $timeafter])->update($visitdata);
            $data['status'] = 1;
            $doordisplay = DoorDisplay::where('doors_id', '=', $visit->doors_id)->update($data);

            $doors = Door::where('id', '=', $visit->doors_id)->first();

            try {
                $encoded = $this->my_encrypt($doors->door_id, $key);

                $fp = fsockopen($doors->ip, $doors->port, $errno, $errstr, 30);

                if (!$fp) {
                    echo "$errstr ($errno)<br />\n";
                } else {
                    fwrite($fp, $encoded);
                    $output = fread($fp, 2);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Durys neatsako');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Neteisingas kodas');
        }

        return view('close');
    }
}
