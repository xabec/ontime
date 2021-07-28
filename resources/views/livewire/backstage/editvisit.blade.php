@extends ('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Redaguoti duris' }}</div>

                    <div class="card-body">

                        <div>
                            <form class="form-horizontal" role="form" method="POST" action="{{route('visit.confirmedit', $selectedVisit->getKey()) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group" >
                                    <fieldset disabled>
                                    <label>Gydytojas:</label>
                                    <select wire:model="visitdoctor" id="visitdoctor" type="text" class="custom-select" name="visitdoctor" required>
                                        <option selected>{{ $doctorname->name }}</option>
                                    </select>
                                        </fieldset>
                                </div>

                                <div class="form-group" >
                                    <fieldset disabled>
                                    <label>Senas vizito laikas:</label>
                                    <input class="form-control" type="text" value="{{$selectedVisit->visit_date}}" required>
                                    </fieldset>
                                </div>

                                <div class="form-group" >
                                    <label>Nauja vizito diena:</label>
                                    <input wire:model="date" class="date form-control" type="text" required>
                                </div>


                                <div class="form-group" >
                                    <label>Naujas vizito laikas:</label>
                                    <select wire:model="visittime" id="visittime" type="text" name="visittime" class="custom-select" required>
                                        <option selected>Galimi laikai...</option>
                                        {{$i = 0}}


{{--                                        @while($i != 16)--}}

{{--                                            @foreach($visits as $visit)--}}
{{--                                                @if($visitdate->hour == 12)--}}
{{--                                                    {{ $visitdate->addHour() }}--}}
{{--                                                @elseif($visit->visit_date == $visitdate)--}}
{{--                                                    {{ $visitdate->addMinutes(30) }}--}}
{{--                                                    {{ $i++ }}--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}

{{--                                            @if($visitdate->hour == 12)--}}
{{--                                                {{ $visitdate->addHour() }}--}}
{{--                                            @else--}}
{{--                                                <option value="{{$visitdate}}">{{$visitdate->toTimeString()}}--}}
{{--                                                    - @if(($visitdoctor)) {{ $selecteddoctor->name }} @endif</option>--}}
{{--                                                {{ $visitdate->addMinutes(30) }}--}}
{{--                                                {{ $i++ }}--}}
{{--                                            @endif--}}

{{--                                        @endwhile--}}

                                    </select>
                                </div>

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

        <script type="text/javascript">
            $('.date').datepicker({
                format: "yyyy-mm-dd",
                weekStart: 1,
                startDate: "{{ $visitdate }}",
                language: "lt",
                daysOfWeekDisabled: "0,6",
                daysOfWeekHighlighted: "1",
            });
        </script>


@endsection
