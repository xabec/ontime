<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\Door;
use App\Models\DoorDisplay;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DoorTableController extends TableComponent
{
    public $sortField = 'id';

    public function delete($id)
    {
        Door::where('id','=', $id)->delete();
        DoorDisplay::where('door_ids', '=', $id)->delete();
        return Redirect::to('/doors ')->with('success', 'Durys pašalintos');
    }

    public function confirmEdit(Request $request, $id)
    {
        $validator = Validator::make(
            [   'id' =>$request->accepts('id'),
                'ip' =>$request->input('ip'),
                'port' =>$request->input('port'),
                'name' =>$request->input('name'),
                'department' => $request->input('department'),
                'door_id' => $request->input('door_id')

            ],
            [   'ip' => 'required|max:255',
                'port' => 'required|max:10',
                'name' =>'nullable|max:255',
                'department' =>  'nullable|max:255',
                'door_id' => 'required|max:2'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            $appendableData = $request->all();
            //pašaliname iš masyvo saugumui naudojamą _token kintamąjį
            unset($appendableData ['_token']);

            $doors = Door::where('id','=',$id)->update($appendableData);
        }
        return Redirect::to('/doors')->with('success', 'Durys atnaujintos');
    }

    public function edit($id)
    {
        $selectedDoor  = Door::where('id','=',$id)->first();
        return view('livewire.backstage.editdoors', compact('selectedDoor'));
    }

    public function rights($id)
    {
        $selectedDoor  = Door::where('id','=', $id)->first();
        $users = User::select('*')->get();
        return view('livewire.backstage.rightscontrol', compact('selectedDoor', 'users'));
    }

    public function insertRights(Request $request, $id)
    {
        $validator = Validator::make(
            [
                'user' =>$request->input('user'),
            ],
            [
                'user' => 'required|max:255',
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {

            $userId = $request->input('user');

            $doors = Door::where('id','=', $id)->first();
            $doors->rights()->firstOrCreate(['user_id'=> $userId]);


            $checkdoctor = Doctor::where('user_id', '=', $userId)->first();
            if (empty($checkdoctor))
            {
                $doctor = new Doctor();
                $doctor->user_id = $request->input('user');
                $doctor->save();
            }

            $data['account_rank'] = '1';
            $user = User::where('id', '=', $request->input('user'))->update($data);
        }
        return Redirect::to('/doors')->with('success', 'Teisės pridetos');
    }

    public function insert(Request $request)
    {
        $validator = Validator::make(
            [   'ip' =>$request->input('ip'),
                'port' =>$request->input('port'),
                'name' =>$request->input('name'),
                'department' => $request->input('department'),
                'door_id' => $request->input('door_id')
            ],
            [   'ip' => 'required|max:255',
                'port' => 'required|max:10',
                'name' =>'nullable|max:255',
                'department' =>  'nullable|max:255',
                'door_id' => 'required|max:2'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            $door = new door();
            $door->ip  = $request->input('ip');
            $door->port = $request->input('port');
            $door->name = $request->input('name');
            $door->department = $request->input('department');
            $door->door_id = $request->input('door_id');

            $door->save();
        }
        return Redirect::to('/doors')->with('success', 'Durys pridėtos');
    }

    public function render()
    {
        $user = User::where('id', '=', Auth::id())->first();
        if ($user->account_rank == 0)
        {
            $this->redirect('home');
        }

        $this->hasNew = true;

        $columns = [
            [
                'title' => 'Pavadinimas',
                'attribute' => 'name',
                'sort' => true,
            ],
            [
                'title' => 'IP adresas',
                'attribute' => 'ip',
                'sortField' => 'ip',
                'sort' => true,
            ],
            [
                'title' => 'Port',
                'attribute' => 'port',
                'sortField' => 'port',
                'sort' => true,
            ],
            [
                'title' => 'Skyrius',
                'attribute' => 'department',
                'sortField' => 'department',
                'sort' => true,
            ],
            [
                'title' => 'Durų id',
                'attribute' => 'door_id',
                'sortField' => 'door_id',
                'sort' => true,
            ],
        ];

        $columns[] = [
            'title' => 'Įrankiai',
            'sort' => false,
            'tools' => ['edit.door', 'remove.door', 'edit_rights.door', 'display_info.door', 'change_status.door'],
        ];


        $rows = Door::search($this->search)
            ->when(auth()->user()->account_rank != '2', function ($query) {
                $query->whereHas('rights', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
            ->paginate($this->perPage);

        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'durys',
            'rows' => $rows,
            'user' => $user
        ]);
    }
}
