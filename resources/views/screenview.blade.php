@extends('layouts.screen')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">
                        @livewire('screen-view')

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
