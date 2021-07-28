@extends('layouts.app')

@section('content')
    <button onclick="window.close()">Uždaryti</button>
@endsection

@push('js')
    <script>
        window.close();
    </script>
@endpush
