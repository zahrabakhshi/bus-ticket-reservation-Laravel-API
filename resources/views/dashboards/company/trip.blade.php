@extends('dashboards.dashboard-layout')
@section('dashboard-title',__('trip'))
@can('companyGate')
@section('inner-content')

    <form action="{{route('trip.update',['trip' => $id])}}" method="post">
        @csrf
        {{ method_field('PUT') }}
        {{--        {{dd($origin_location)}}--}}
        <input type="hidden" name="origin_location_id" value="{{$origin_location->id}}">

        <input type="hidden" name="destination_location_id" value="{{$destination_location->id}}">

        <div class="input-group input-group mb-3 d-flex justify-content-center" dir="ltr">


            <input type="text" name="end_time" value="{{date('H:i:s',$end_time)}}"
                   class="form-control  col-3 text-center" placeholder="{{__('end time')}}">

            <input type="text" class="form-control col-2 text-center" value="{{__('end time')}}" disabled>

            <input type="text" value="{{date('H:i:s',$start_time)}}" name="start_time"
                   class="form-control  col-3 text-center" placeholder="{{__('start time')}}">

            <input type="text" class="form-control col-2 text-center" value="{{__('start time')}}" disabled>

            <input type="text" value="{{date('Y-m-d',$start_time)}}" name="date"
                   class="form-control col-3 text-center" placeholder="{{__('departure date')}}">

            <input type="text" class="form-control col-1 text-center" value="{{__('date')}}" disabled>

        </div>

        <div class="input-group input-group mb-3 d-flex justify-content-center" dir="ltr">

            @if(empty($towns))

                <input type="text" title="{{__('please add many town')}}"
                       class="form-control col-4 text-center bg-light" value="{{__('no town')}}" disabled>

            @else
                <select name="destination" class="form-control col-3 text-center">

                    <option value="{{$destination_town->id}}" selected>{{$destination_town->name}}</option>
                    @foreach($towns as $town)
                        @if($town['id'] == $destination_town->id)
                            @continue
                        @endif
                        <option value="{{$town['id']}}">{{$town['name']}}</option>

                    @endforeach

                </select>
                <input type="text" class="form-control col-1 text-center" value="{{__('destination')}}" disabled>

                <select name="origin" class="form-control col-3 text-center">

                    <option value="{{$origin_town->id}}" selected>{{$origin_town->name}}</option>
                    @foreach($towns as $town)
                        @if($town['id'] == $origin_town->id)
                            @continue
                        @endif

                        <option value="{{$town['id']}}">{{$town['name']}}</option>

                    @endforeach

                </select>

                <input type="text" class="form-control col-1 text-center" value="{{__('origin')}}" disabled>
            @endif
            <select name="vehicle" class="form-control col-3 text-center">

                <option value="{{$vehicle['id']}}" selected>{{$vehicle->name}}</option>
                @foreach($vehicles as $vehicle0)

                    @if($vehicle0['id'] == $vehicle->id)
                        @continue
                    @endif

                    <option value="{{$vehicle0['id']}}">{{$vehicle0['name'] ?? $vehicle0['plate']}}</option>

                @endforeach

            </select>
            <input type="text" class="form-control col-2 text-center" value="{{__('vehicle')}}" disabled>

        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-success text-light w-25 mb-3" type="submit">{{__('update')}}</button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <form method="post" action="{{route('trip.destroy',['trip' => $id])}}">
        @csrf
        {{ method_field('DELETE') }}
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-danger w-25">{{__('delete')}}</button>
        </div>
    </form>
@endsection
@endcan
