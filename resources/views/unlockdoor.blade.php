@extends('layouts.screen')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @livewire('unlock-door')
                    </div>
                </div>
            </div>
        </div>
@endsection
