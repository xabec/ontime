<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Vizito registracija') }}</div>

                <div class="card-body">


                        <div>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('registervisit/insert') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group" >
                                    <label>Gydytojas:</label>
                                    <select wire:model="visitdoctor" id="visitdoctor" type="text" class="custom-select" name="visitdoctor" required>
                                        <option selected></option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->name}} - {{$doctor->profession}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Vizito data:</label>
                                    <input wire:model="date" class="datepicker form-control" type="text" readonly required>
                                </div>

                                <div class="form-group" >
                                    <label>Vizito laikas:</label>
                                    <select wire:model="visittime" id="visittime" type="text" name="visittime" class="custom-select" required>
                                        <option selected>Galimi laikai...</option>

                                            {{$i = 0}}


                                            @while($i != 16)
                                            @foreach($visits as $visit)
                                                @if($visit->visit_date == $visitdate)
                                                    {{ $visitdate->addMinutes(30) }}
                                                    {{ $i++ }}
                                                @endif
                                            @endforeach

                                                @if($visitdate->hour == 12)
                                                    {{ $visitdate->addHour() }}
                                                @else
                                                    <option value="{{$visitdate}}">{{$visitdate->toTimeString()}}
                                                        @if(($visitdoctor)) - {{ $selecteddoctor->name }} @endif</option>
                                                    {{ $visitdate->addMinutes(30) }}
                                                    {{ $i++ }}
                                                @endif

                                            @endwhile
                                    </select>
                                </div>

                                @guest()

                                    <div class="form-group">
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email">El. paštas</label>
                                            <input type="email" class="form-control" id="email" placeholder="El. paštas" name="email" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Vardas pavardė</label>
                                            <input type="text" class="form-control" id="name" placeholder="Vardas pavardė" name="name" required>
                                        </div>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-4">
                                            <label for="identity_number">Asmens kodas</label>
                                            <input type="text" class="form-control" placeholder="Asmens kodas" id="identity_number" name="identity_number" required>
                                        </div>
                                        <div class="col">
                                            <label for="phone_number">Mob. numeris</label>
                                            <input type="text" class="form-control" placeholder="Mob. numeris" id="phone_number" name="phone_number">
                                        </div>
                                        <div class="col">
                                            <label for="birth_date">Gimimo data</label>
                                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                        </div>
                                    </div>
                                </div>

                                @endguest

                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-refresh"></span>
                                            Registruotis
                                        </button>
                                    </div>
                                </div>
                            </form>

                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $.fn.datepicker.dates['lt'] = {
        days: ["Sekmadienis", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis"],
        daysShort: ["S", "Pr", "A", "T", "K", "Pn", "Š"],
        daysMin: ["Sk", "Pr", "An", "Tr", "Ke", "Pn", "Št"],
        months: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"],
        monthsShort: ["Sau", "Vas", "Kov", "Bal", "Geg", "Bir", "Lie", "Rugp", "Rugs", "Spa", "Lap", "Gru"],
        today: "Šiandien",
        monthsTitle:"Mėnesiai",
        clear:"Išvalyti",
        weekStart: 1,
        format:"yyyy-mm-dd"
    };

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        startDate: "new Date()",
        language: "lt",
        daysOfWeekDisabled: "0,6",
        daysOfWeekHighlighted: "1",

    }).on('changeDate', function () {
        @this.set('date', $('.datepicker').val());
    });
</script>
@endpush
