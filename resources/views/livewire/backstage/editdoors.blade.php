@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Durų redagavimas' }}</div>

                    <div class="card-body" >

                            <div>
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{route('doors.confirmedit', $selectedDoor->getKey())}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label>Durų pavadinimas</label>
                                        <div>
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ $selectedDoor->name }}">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>IP adresas</label>
                                        <div>
                                            <input type="text" class="form-control" name="ip"
                                                   value="{{ $selectedDoor->ip }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Portas</label>
                                        <div>
                                            <input type="text" class="form-control" name="port"
                                                   value="{{ $selectedDoor->port }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Skyrius:</label>
                                        <div>
                                            <input type="text" class="form-control" name="department"
                                                   value="{{ $selectedDoor->department }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Durų id valdiklyje:</label>
                                        <div>
                                            <input type="text" class="form-control" name="door_id"
                                                   value="{{ $selectedDoor->door_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-refresh"></span>
                                                Redaguoti
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
