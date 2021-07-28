 <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">


                    @if (empty($thisdoctor) || empty($thisdoordisplay))
                        <div>
                            <select wire:model="thisdoordisplay" class="custom-select">
                                <option selected> Pasirinkite ekraną...</option>
                                @foreach($doordisplays as $doordisplay)
                                    <option value="{{$doordisplay->id}}"> {{ $doordisplay->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>

                        <div>
                            <select wire:model="thisdoctor" class="custom-select">
                                <option selected> Pasirinkite gydytoją...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}"> {{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                        @if (!empty($thisdoctor) && !empty($thisdoordisplay))

                        <div style="text-align:center;font-size:50px"><b>{{$selecteddisplay->cabinet_number}}</b></div>
                        <div style="text-align:center;font-size:50px"><b>{{$selecteddisplay->name}}</b></div>
                        <div style="text-align: center;font-size:30px"><b>{{$selecteddoctoruser->name}}</b> - <b>{{$selecteddoctor->profession}}</b></div><br>
                        <div wire:poll>
                        <p style="text-align: left;font-size:20px">Statusas: @if ($selecteddisplay->status == 0)<a style="color: red">Uždaryta</a>
                        @else <a style="color: green">Atidaryta</a> @endif</p>
                        @if ($selecteddisplay->status == 1)
                            @else
                        <p style="text-align: right"><span onclick="window.open('http://65.21.176.181/unlock', 'targetWindow',
                                   ``)"><img src="../images/unlockicon.png" width="50" height="50"></span></p>
                            @endif
                            @endif
                        </div>


                </div>
            </div>
        </div>
    </div>

