@extends('dashboards.dashboard-layout')
@section('dashboard-title',__('Dashboard'))
@can('companyGate')
@section('inner-content')
    <div class="d-flex flex-column">
        <div>
            @empty($vehicles)
                <div class="alert alert-secondary" role="alert">
                    {{__('There is no vehicle')}}
                </div>
            @endempty
            {{--    {{dd($vehicles)}}--}}
            @if( ! empty($vehicles))
                <div class="list-group w-100 mb-5">
                    @foreach($vehicles as $vehicle)
                        <a href="{{route('vehicle.show',['vehicle' => $vehicle['id']])}}"
                           class="list-group-item list-group-item-action">
                            <p class="h4 text-primary pb-3">{{$vehicle['name'] ?? __('no name')}}</p>
                            <p class="m-0" title="{{__("plate_number")}}">{{$vehicle['plate']}}</p>
                        </a>
                    @endforeach
                </div>
            @endif
            <div>
                <form method="post" action="{{route('vehicle.store')}}" dir="ltr">
                    @csrf

                    <div class="input-group input-group mb-3 d-flex justify-content-center" dir="ltr">
                        <div class="input-group-prepend">
                            <button class="btn btn-success text-light "
                                    type="submit">{{__('Add a new vehicle')}}</button>
                        </div>
                        <input type="text" name="plate4"
                               class="form-control col-2 text-center"
                               placeholder="45">
                        <input type="text" name="plate3"
                               class="form-control col-2 text-center"
                               placeholder="ج">
                        <input type="text" name="plate2"
                               class="form-control col-3 text-center"
                               placeholder="235">
                        <input type="text" name="plate1"
                               class="form-control col-2 text-center"
                               placeholder="11">
                        <input type="text" class="form-control border bg-secondary text-light col-2 text-center"
                               value="{{__('plate number')}}" disable>
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
            </div>

        </div>
        <div class="my-5"></div>
        <div class="d-flex flex-column align-items-center">
            @empty($trips)
                <div class="alert alert-secondary w-100" role="alert">
                    {{__('There is no trip')}}
                </div>
            @endempty
            {{--    {{dd($vehicles)}}--}}
            @if( ! empty($trips))
                <div class="list-group w-100 mb-5">
                    @foreach($trips as $trip)
                        <a href="{{route('trip.show',['trip' => $trip['id']])}}"
                           class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-1 text-center p-0 border-left">
                                    <span class="h4 text-primary">{{$trip['id']}}</span><br>
                                    <span class="small">{{date('m/d',$trip['start_time'])}}</span>
                                </div>
                                <div class="col-10 d-flex flex-column">
                                    <div class="">
                                        <span class="h4 text-primary border-bottom">
                                            {{$trip['origin']->name}}
                                            <span class="h6 text-secondary">
                                                {{date('H:i',$trip['start_time'])}}
                                            </span>
                                            -
                                            {{$trip['destination']->name}}
                                            <span class="h6 text-secondary">
                                                {{date('H:i',$trip['end_time'])}}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="pt-2">
                                        <span class="text-secondary"
                                              href="{{route('vehicle.show',['vehicle' => $trip['vehicle']->id])}}">
                                       {{__('vehicle')}} : {{$trip['vehicle']->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>


                        </a>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('trip.store')}}" dir="ltr">
                @csrf

                <div class="input-group input-group-sm mb-3 d-flex justify-content-center" dir="ltr">
                    <div class="input-group-prepend">
                        <button class="btn btn-success text-light " type="submit">{{__('add new trip')}}</button>
                    </div>

                    <input type="text" onfocus="this.type='time'" onblur="this.type='text'" name="end_time"
                           class="form-control  col-3 text-center" placeholder="{{__('end time')}}">

                    <input type="text" onfocus="this.type='time'" onblur="this.type='text'" name="start_time"
                           class="form-control  col-3 text-center" placeholder="{{__('start time')}}">

                    <input type="text" onfocus="this.type='date'" onblur="this.type='text'" name="date"
                           class="form-control col-3 text-center" placeholder="{{__('departure date')}}">

                    @if(empty($towns))

                        <input type="text" title="{{__('please add many town')}}"
                               class="form-control col-4 text-center bg-light" value="{{__('no town')}}" disabled>

                    @else
                        <select name="destination" class="form-control col-3 text-center">

                            <option disabled selected>{{__('destination')}}</option>
                            @foreach($towns as $town)

                                <option value="{{$town['id']}}">{{$town['name']}}</option>

                            @endforeach

                        </select>

                        <select name="origin" class="form-control col-3 text-center">

                            <option disabled selected>{{__('origin')}}</option>
                            @foreach($towns as $town)

                                <option value="{{$town['id']}}">{{$town['name']}}</option>

                            @endforeach

                        </select>

                    @endif
                    <select name="vehicle" class="form-control col-3 text-center">

                        <option disabled selected>{{__('vehicle')}}</option>
                        @foreach($vehicles as $vehicle)

                            <option value="{{$vehicle['id']}}">{{$vehicle['name'] ?? $vehicle['plate']}}</option>

                        @endforeach

                    </select>

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

            <form class="w-50" method="post" action="{{route('town.store')}}" dir="ltr">
                @csrf
                <div class="input-group input-group-sm mb-3 d-flex justify-content-center" dir="ltr">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-secondary">{{__('add new town')}}</button>
                    </div>
                    <input class="form-control text-right" type="text" name="name" placeholder="{{__('town name')}}">
                </div>
            </form>

        </div>
    </div>


@endsection
@endcan
