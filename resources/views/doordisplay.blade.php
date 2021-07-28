@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Ekrano informacija' }}</div>

                    <div class="card-body">

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('doors/doordisplay/insert', $doors->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label>Kabineto pavadinimas</label>
                                @if (!empty($displayinfo->name))
                                    <input type="text" class="form-control" name="name" value="{{ $displayinfo->name }}"
                                           required>
                                @else
                                    <input type="text" class="form-control" name="name" required>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Kabineto numeris</label>
                                @if (!empty($displayinfo->cabinet_number))
                                    <input type="text" class="form-control" name="cabinet_number"
                                           value="{{ $displayinfo->cabinet_number }}" required>
                                @else
                                    <input type="text" class="form-control" name="cabinet_number" required>
                                @endif
                            </div>


                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                        Išsaugoti
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
