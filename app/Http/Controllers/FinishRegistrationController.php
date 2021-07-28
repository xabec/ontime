<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FinishRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $id = Auth::id();
        $user = User::where('id', '=', $id)->first();
        $identity_number = Crypt::decryptString($user->identity_number);
        return view('livewire.backstage.edituser', compact('user', 'identity_number'));
    }

    public function doctorEdit()
    {
        $id = Auth::id();
        $user = User::where('id', '=', $id)->first();
        $doctor = Doctor::where('user_id', '=', $id)->first();
        return view('livewire.backstage.editdoctor', compact('user', 'doctor'));
    }

    public function doctorConfirm(Request $request)
    {
        $validator = Validator::make(
            [   'profession' =>$request->input('profession'),
                'awards' =>$request->input('awards'),
                'years_active' =>$request->input('years_active')

            ],
            [   'profession' => 'nullable|max:255',
                'awards' => 'nullable|max:255',
                'years_active' => 'nullable|max:11|numeric'
            ]
        );

        if ($validator->fails())
        {
            return redirect('home')->withErrors($validator);
        }
        else
        {
            $appendableData = $request->all();
            //pašaliname iš masyvo saugumui naudojamą _token kintamąjį
            unset($appendableData ['_token']);
            $doctor = Doctor::where('user_id','=',Auth::id())->update($appendableData);
        }
        return redirect('home')->with('success', 'Duomenys sėkmingai atnaujinti');
    }

    public function confirmEdit(Request $request)
    {
        $validator = Validator::make(
            [   'name' =>$request->input('name'),
                'email' =>$request->input('email'),
                'identity_number' =>$request->input('identity_number'),
                'phone_number' =>$request->input('phone_number'),
                'birth_date' =>$request->input('birth_date')

            ],
            [   'name' => 'required|max:255',
                'email' => 'required|max:255',
                'identity_number' => 'required|max:11',
                'phone_number' => 'nullable|size:7|regex:/^[0-9]+$/',
                'birth_date' =>'required'
            ]
        );

        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {
            $appendableData = $request->all();

            if (! empty($appendableData['phone_number'])) {
                $appendableData['phone_number'] = '86' . $appendableData['phone_number'];
            }
            $appendableData['identity_number'] = Crypt::encryptString($request->input('identity_number'));
            //pašaliname iš masyvo saugumui naudojamą _token kintamąjį
            unset($appendableData ['_token']);
            $user = User::where('id','=',Auth::id())->update($appendableData);
        }
        return redirect()->route('home')->with('success', 'Duomenys sėkmingai atnaujinti');
    }

    public function index()
    {
        $id = Auth::id();
        $user = User::where('id', '=', $id)->get()->first();
        if (!empty($user->identity_number) && !empty($user->birth_date))
            return redirect()->route('home');
        else { return view('auth.finishregistration', compact('user')); };
    }

    public function confirmFinish(Request $request)
    {
        $validator = Validator::make(
            [   'identity_number' =>$request->input('identity_number'),
                'phone_number' =>$request->input('phone_number'),
                'birth_date' =>$request->input('birth_date')

            ],
            [   'identity_number' => 'required|max:11',
                'phone_number' => 'nullable|max:15',
                'birth_date' =>'required'
            ]
        );

        if ($validator->fails())
        {
            return redirect('home')->withErrors($validator);
        }
        else
        {
            $appendableData = $request->all();
            $appendableData['identity_number'] = Crypt::encryptString($request->input('identity_number'));
            //pašaliname iš masyvo saugumui naudojamą _token kintamąjį
            unset($appendableData ['_token']);
            $user = User::where('id','=',Auth::id())->update($appendableData);
        }
        return redirect('home')->with('success', 'Duomenys išsaugoti');
    }
}
