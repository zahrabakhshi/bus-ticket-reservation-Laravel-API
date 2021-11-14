@extends('dashboards.dashboard-layout')
@can('adminGate')
@section('content')
    <div class="list-group w-100">
        @foreach($vehicles as $vehicle)
            <a href="#" class="list-group-item list-group-item-action active">
                Cras justo odio
            </a>
            <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
            <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
            <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>
        @endforeach
    </div>
@endsection
@endcan
