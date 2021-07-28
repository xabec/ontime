@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Gydytojo duomenų redagavimas' }}</div>


                    <div class="card-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('user/doctor/confirmedit')  }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label>Profesija</label>
                                <input type="text" class="form-control" name="profession"
                                       @if(!empty($doctor->profession)) value="{{$doctor->profession}}" @endif>
                            </div>

                            <div class="form-group">
                                <label>Apdovanojimai</label>
                                <input type="text" class="form-control" name="awards"
                                       @if(!empty($doctor->awards)) value="{{$doctor->awards}}" @endif>
                            </div>

                            <div class="form-group">
                                <label>Darbo patirtis (metais)</label>
                                <input type="text" class="datepicker form-control" name="years_active"
                                       @if(!empty($doctor->years_active)) value="{{$doctor->years_active}}" @endif>
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
