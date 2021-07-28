@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">

                        <div style="text-align: center">
                        <b style="size: 20px">Vizito laikas: {{ $thisvisit->visit_date }}</b>
                    </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label>Gydytojo komentarai:</label>
                                <div>
                                    <input type="text" class="form-control" value="{{$thisvisit->comments}}" readonly>
                                </div>

                            </div>
                            <div class="form-group">
                                <div>
                                    <label>Rekomandacijos</label>
                                    <input type="text" class="form-control" value="{{$thisvisit->recommendations}}" readonly>
                                </div>
                            </div>

                    <div class="form-group">
                        <div>
                            <label>Išvados</label>
                            <input type="text" class="form-control" value="{{$thisvisit->conclusion}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label>Atrakinimo kodas</label>
                                <input type="text" id="ip" class="form-control" readonly
                                       value="{{$thisvisit->unlock_id}}">
                            </div>
                            <div class="col">
                                <label>Užbaigimo data</label>
                                <input type="text" id="port" class="form-control" readonly
                                       value="{{$thisvisit->date_confirmed}}">
                            </div>
                            <div class="col">
                                <label>Gydytojas</label>
                                <input type="text" id="door_id" class="form-control" readonly
                                       value="{{$thisdoctor->name}}">
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
