@extends('dashboards.dashboard-layout')
@section('dashboard-title',__('vehicle'))
@can('companyGate')
@section('inner-content')

    <form action="{{route('vehicle.update',['vehicle' => $id])}}" method="post">
        @csrf
        {{ method_field('PUT') }}

        <div class="input-group d-flex justify-content-center mb-3" dir="ltr">

            <input type="text" class="form-control col-1 text-center bg-info text-light" value="IR" disabled>

            <input type="text" name="plate4" class="form-control col-1 text-center" value="{{$plate3}}">

            <input type="text" name="plate3" class="form-control col-1 text-center" value="{{$plate2}}">

            <input type="text" name="plate2" class="form-control col-2 text-center" value="{{$plate1}}">

            <input type="text" name="plate1" class="form-control col-1 text-center" value="{{$plate0}}">

            <div class="input-group-append">
                <span class="input-group-text bg-dark text-light"
                      dir="{{__("direction")}}">{{__('plate number')}}</span>
            </div>

        </div>

        <div class="input-group d-flex justify-content-center mb-3" dir="ltr">

            <input type="text" name="company_creator" class="form-control col-4 text-center"
                   value="شرکت سازنده ">

            <input type="text" class="form-control col-1 text-center" value="{{__('company')}}"
                   disabled>

            <input type="text" name="type" class="form-control col-3 text-center " value="{{$type}}">

            <input type="text" class="form-control col-1 text-center" value="{{__('type')}}"
                   disabled>

            <input type="text" name="name" class="form-control col-3 text-center" value="{{$name}}">

            <input type="text" class="form-control col-1 text-center" value="{{__('Name')}}"
                   disabled>

            <div class="input-group-append">
                <span class="input-group-text bg-dark text-light"
                      dir="{{__("direction")}}">{{__('vehicle specifications')}}</span>
            </div>

        </div>

        <div class="input-group input-group d-flex justify-content-center mb-3" dir="ltr">

            <select class="custom-select col-4 text-center" name="has_monitor">
                <option value="{{$has_monitor['value']}}" selected>{{__($has_monitor['selected'])}}</option>
                <option value="{{!$has_monitor['value']}}">{{__($has_monitor['other'])}}</option>
            </select>

            <select class="custom-select col-4 text-center" name="seat_bed">
                <option value="{{$seat_bed['value']}}" selected>{{__($seat_bed['selected'])}}</option>
                <option value="{{!$seat_bed['value']}}">{{__($seat_bed['other'])}}</option>
            </select>

            <select class="custom-select col-4 text-center" name="catering">
                <option value="{{$catering['value']}}" selected>{{__($catering['selected'])}}</option>
                <option value="{{!$catering['value']}}">{{__($catering['other'])}}</option>
            </select>

            <select class="custom-select col-4 text-center" name="is_vip">
                <option value="{{$is_vip['value']}}" selected>{{__($is_vip['selected'])}}</option>
                <option value="{{!$is_vip['value']}}">{{$is_vip['other']}}</option>
            </select>

            <input type="number" name="seats_number" class="form-control col-4 text-center" value="{{$seats_number}}">

            <input type="text" class="form-control col-2 text-center " value=":{{__('seats number')}}" disabled>

            <div class="input-group-append">
                <span class="input-group-text bg-dark text-light"
                      dir="{{__("direction")}}">{{__('vehicle info')}}</span>
            </div>

        </div>

        <div class="d-flex justify-content-center mb-3">
            <button type="submit" class="btn btn-success w-25">{{__('update')}}</button>
        </div>
    </form>

    <form method="post" action="{{route('vehicle.destroy',['vehicle' => $id])}}">
        @csrf
        {{ method_field('DELETE') }}
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-danger w-25">{{__('delete')}}</button>
        </div>
    </form>
@endsection
@endcan
