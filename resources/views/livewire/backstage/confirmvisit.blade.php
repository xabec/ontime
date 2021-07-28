@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Vizito užbaigimas' }}</div>

                    <div class="card-body">

                        <div>
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{route('visit.confirmcomplete', $selectedVisit->getKey())}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="form-row">
                                        <fieldset disabled>
                                            <label>Vizito data:</label>
                                            <div>
                                                <input type="text" class="form-control" name="visit_date"
                                                       value="{{ $selectedVisit->visit_date }}">
                                            </div>
                                        </fieldset>

                                        <div class="col">
                                            <fieldset disabled>
                                                <label>Kliento vardas:</label>
                                                <div>
                                                    <input type="text" class="form-control" name="name"
                                                           value="{{ $client->name }}">
                                                </div>
                                        </div>
                                        <fieldset disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Vizito komentarai</label>
                                    <div>
                                        <input type="text" class="form-control form-control-lg" name="comments"
                                               value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Rekomendacijos</label>
                                    <div>
                                        <input type="text" class="form-control form-control-lg" name="recommendations"
                                               value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Išvados</label>
                                    <div>
                                        <input type="text" class="form-control" name="conclusion"
                                               value="">
                                    </div>
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
    </div>
@endsection
