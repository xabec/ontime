@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Paskyros redagavimas' }}</div>


                    <div class="card-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('user/confirmedit') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label>Vardas pavardė</label>
                                <input type="text" class="form-control" name="name" required
                                       value="{{ $user->name }}">
                            </div>

                            <div class="form-group">
                                <label>El. paštas</label>
                                <input type="text" class="form-control" name="email" required
                                       value="{{ $user->email }}">
                            </div>

                            <div class="form-group">
                                <label>Gimimo data</label>
                                <input type="text" class="datepicker form-control" name="birth_date" required
                                       value="{{ $user->birth_date }}">
                            </div>

                            <div class="form-group">
                                <label>Asmens kodas</label>
                                <input type="text" class="form-control" name="identity_number" required readonly
                                       value="{{ $identity_number }} ">
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">86</span>
                                </div>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                       value="{{ old('phone_number') ?? substr($user->phone_number, 2) }} ">

                                @error('phone_number')
                                <div class="invalid-feedback">
                                    Neteisingas mobilaus numerio formatas.
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                        Atnaujinti duomenis
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

@push('js')
    <script>
        $.fn.datepicker.dates['lt'] = {
            days: ["Sekmadienis", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis"],
            daysShort: ["S", "Pr", "A", "T", "K", "Pn", "Š"],
            daysMin: ["Sk", "Pr", "An", "Tr", "Ke", "Pn", "Št"],
            months: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"],
            monthsShort: ["Sau", "Vas", "Kov", "Bal", "Geg", "Bir", "Lie", "Rugp", "Rugs", "Spa", "Lap", "Gru"],
            today: "Šiandien",
            monthsTitle: "Mėnesiai",
            clear: "Išvalyti",
            weekStart: 1,
            format: "yyyy-mm-dd"
        };

        $('.datepicker').datepicker({
            format: "yyyy-mm-dd",
            weekStart: 1,
            language: "lt",
            daysOfWeekHighlighted: "1",
        });
    </script>
@endpush
