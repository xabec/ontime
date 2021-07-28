<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class VisitTableController extends TableComponent
{
    public $sortField = 'id'; public $userlevel = ''; public $date = '';

    public function edit($id)
    {
        $selectedVisit  = Visit::where('id','=',$id)->first();
        $doctorname = User::where('id', '=', $selectedVisit->doctor_id)->first();
        $visitdate = (new Carbon($selectedVisit->visit_date))->toDateString();
        $visits = Visit::where('doctor_id', '=', $selectedVisit->doctor_id)
            ->where('date_created', '=', $this->date)->get();

        return view('livewire.backstage.editvisit', compact('selectedVisit','doctorname', 'visitdate', 'visits'));
    }

    public function delete($id)
    {
        Visit::where('id','=', $id)->delete();
        return Redirect::to('/visits ')->with('success', 'Vizitas pašalintas');
    }


    public function complete($id)
    {
        $selectedVisit  = Visit::where('id','=',$id)->first();
        $client = User::where('id', '=', $selectedVisit->user_id)->first();
        return view('livewire.backstage.confirmvisit', compact('selectedVisit','client'));
    }

    public function confirmComplete(Request $request, $id)
    {
        $validator = Validator::make(
            [   'comments' =>$request->input('comments'),
                'recommendations' =>$request->input('recommendations'),
                'conclusion' =>$request->input('conclusion'),
            ],
            [   'comments' => 'required|max:1000',
                'recommendations' => 'nullable|max:1000',
                'conclusion' =>'nullable|max:1000',
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            $appendableData = $request->all();
            $appendableData['status'] = 2;
            $appendableData['date_confirmed'] = Carbon::now()->setTimezone(3)->toDateTimeString();
            //pašaliname iš masyvo saugojimui naudojamą _token kintamąjį
            unset($appendableData ['_token']);
            $visits = Visit::where('id','=',$id)->update($appendableData);
        }
        return Redirect::to('/visits')->with('success', 'Vizitas užbaigtas');
    }

    public function render()
    {
        $this->hasNew = false;

        $id = Auth::id();
        $this->userlevel = User::select('account_rank')
        ->where('id', '=', $id)->first();

        $checkuser = User::where('id', '=', $id)->first();

        if($checkuser->account_rank == 1)
        {
            $rows = Visit::search($this->search)
                ->leftJoin('users', 'users.id', 'visits.doctor_id')
                ->where('doctor_id', '=', $id)
                ->selectRaw('users.name as doctor_name')
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage);
        }
        elseif($checkuser->account_rank == 2)
        {
            $rows = Visit::search($this->search)
                ->leftJoin('users', 'users.id', 'visits.doctor_id')
                ->selectRaw('users.name as doctor_name')
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage);
        }
        else
        {
            $rows = Visit::search($this->search)
                ->leftJoin('users', 'users.id', 'visits.doctor_id')
                ->where('user_id', '=', $id)
                ->selectRaw('users.name as doctor_name')
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage);
        }

        $columns = [
            [
                'title' => 'Vizitas sukurtas',
                'attribute' => 'date_created',
                'sort' => true,
            ],
            [
                'title' => 'Gydytojas',
                'attribute' => 'doctor_name',
                'sortField' => 'doctor_name',
                'sort' => true,
            ],
            [
                'title' => 'Vizito data',
                'attribute' => 'visit_date',
                'sort' => true,
            ],
            [
                'title' => 'Statusas',
                'attribute' => 'status',
                'sort' => true,
            ],
            [
                'title' => 'Atrakinimo kodas',
                'attribute' => 'unlock_id',
                'sortField' => 'unlock_id',
                'sort' => true,
            ],
        ];

        $columns[] = [
            'title' => 'Įrankiai',
            'sort' => false,
            'tools' => ['check.visit', 'remove.visit', 'complete.visit'],
        ];


        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'vizitai',
            'rows' => $rows,
        ]);
    }
}
