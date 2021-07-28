@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Durų prieigos valdymas' }}</div>

                    <div class="card-body">

                        <form role="form" class="form-group" method="POST"
                              action="{{ route('doors.rights.insert', $selectedDoor->getKey()) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Pasirinkite vartotoją</label>
                                <select name="user" class="form-control">
                                    @foreach($users as $singleuser)
                                        @if ($singleuser->account_rank == 0 || $singleuser->account_rank == 1)
                                            <option value="{{$singleuser->id}}"
                                                    class="form-control">{{ $singleuser->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-info btn-block">Išsaugoti</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

