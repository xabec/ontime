@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Užbaigti registraciją' }}</div>

                    <div class="card-body">

                        <div>
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{route('user.confirmfinish')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col">
                                            <label>Vartotojas:</label>
                                            <input type="text" class="form-control" value="{{$user->name}}" readonly>
                                        </div>
                                        <div class="col">
                                            <label>El. paštas</label>
                                            <input type="text" class="form-control" value="{{$user->email}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Asmens kodas</label>
                                    <div>
                                        <input type="text" class="form-control" name="identity_number" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Mobilus numeris</label>
                                    <div>
                                        <input type="text" class="form-control" name="phone_number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Gimimo data</label>
                                    <div>
                                        <input type="date" class="date form-control" name="birth_date">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-refresh"></span>
                                            Patvirtinti
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

@push('js')
    <script type="text/javascript">
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            weekStart: 1,
            language: "lt",
            daysOfWeekHighlighted: "1",
        });
    </script>
@endpush
