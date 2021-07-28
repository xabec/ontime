@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @livewire('visit-controller')

                </div>
            </div>
        </div>
    </div>
@endsection
