@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Klientų srautų valdymo sistema') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p style="text-align:center;">Klientų srautų valdymo sistema, bakalaurinis darbas</p>

                    <p style="text-align: center">Vadovas: prof. dr. <b>Agnius Liutkevičius</b></p>

                    <p style="text-align: center">Recenzentas: lekt. dr. <b>Rolandas Girčys</b></p>

                    <p style="text-align: center">Užsakovas: <b> UAB "BK Grupė"</b></p>
                </div>

                <div class="card-footer" style="text-align: center">
                    Vytautas Šilkaitis IFC-7<br> Kaunas, 2021 ©
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
