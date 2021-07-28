<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\DoorRights;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class VisitController extends Component
{
    public $visitdoctor = ''; public $date = ''; public $visittime = '';

    public function insert(Request $request)
    {

        $validator = Validator::make(
            [   'visit_date' => $request->input('visittime'),
                'unregistereduserdata_email' =>$request->input('email'),
                'unregistereduserdata_name' =>$request->input('name'),
                'unregistereduserdata_identity_number' =>$request->input('identity_number'),
                'unregistereduserdata_phone_number' =>$request->input('phone_number'),
                'unregistereduserdata_birth_date' =>$request->input('birth_date'),
                'doctor_id' =>$request->input('visitdoctor')
            ],
            [   'visit_date' => 'required',
                'unregistereduserdata_email' => 'nullable|max:255',
                'unregistereduserdata_name' =>'nullable|max:255',
                'unregistereduserdata_identity_number' =>'nullable|max:11',
                'unregistereduserdata_phone_number' =>'nullable|max:11',
                'unregistereduserdata_birth_date' =>'nullable',
                'doctor_id' => 'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            $data['email'] = $request->input('email');
            $data['name'] = $request->input('name');
            $data['identity_number'] = $request->input('identity_number');
            $data['phone_number'] = $request->input('phone_number');
            $data['birth_date'] = $request->input('birth_date');
            $door_id = DoorRights::where('user_id', '=', $request->input('visitdoctor'))->value('door_id');

            $visit = new visit();
            $visit->date_created  = Carbon::now()->setTimezone(3)->toDateTimeString();
            $visit->visit_date = $request->input('visittime');
            $visit->unregistereduserdata = $data;
            $visit->unlock_id = rand(0000,9999);
            $visit->doors_id = $door_id;
            $visit->doctor_id = $request->input('visitdoctor');
            $visit->user_id = Auth::id();

            $visit->save();

            if (Auth::check())
            {
                $user = User::where('id', '=', Auth::id())->get()->first();
                $number = $user->phone_number;
                $visitdoctor = User::where('id', '=', $request->input('visitdoctor'))->get()->first();
                $doctorname = $visitdoctor->name;
                $thisvisit = Visit::where('visit_date', '=', $request->input('visittime'))->get()->first();
                $visitcode = $thisvisit->unlock_id;
                $text = 'Registracija vizitui sėkminga! Jūsų vizito gydytojas: '.$doctorname.' Vizito laikas: '
                    .$request->input('visittime').' Durų atrakinimo kodas: '.$visitcode.' Atrakinimo nuoroda: '
                    .'https://webliton.com/doors/open_public/link/?unlock_id='.$visitcode;

                $query = http_build_query([
                    'number' => $number,
                    'text' => $text
                ]);

                try {
                    Http::timeout(10)
                        ->get("http://193.217.9.7/cgi-bin/sms_send?username=messages&password=hakeriaipuola2021&{$query}");
                } catch (\Exception $exception) {

                }

            }
            else
            {
                $thisvisit = Visit::where('visit_date', '=', $request->input('visittime'))->get()->first();
                $visitcode = $thisvisit->unlock_id;
                $visitdoctor = User::where('id', '=', $request->input('visitdoctor'))->get()->first();
                $doctorname = $visitdoctor->name;

            }
        }
        return Redirect::to('/visits')->with('success', 'Vizitas išsaugotas');
    }

    public function render()
    {
        if (Auth::check()) {
            $user = User::where('id', '=', Auth::id())->get()->first();
            if (empty($user->identity_number) && empty($user->birth_date)) {
                $this->redirect('user/finishregistration');
            }
        }
                $doctors = Doctor::leftJoin('users', 'users.id' , 'doctors.user_id')
                    ->get();
                $selecteddoctor = Doctor::leftJoin('users', 'users.id' , 'doctors.user_id')
                    ->select('users.name')
                    ->where('user_id', '=', $this->visitdoctor)->first();
                $visits = Visit::where('doctor_id', '=', $this->visitdoctor)
                    ->where('visit_date', 'LIKE', '%'.$this->date.'%')->get();
                $selecteddate = Carbon::parse($this->date)->setTime(8,0);
                return view('livewire.registervisit', [
                    'doctors' => $doctors,
                    'selecteddoctor' => $selecteddoctor,
                    'visits' => $visits,
                    'visitdate' => $selecteddate,
                    'user_id' => Auth::id()]);
    }
}
