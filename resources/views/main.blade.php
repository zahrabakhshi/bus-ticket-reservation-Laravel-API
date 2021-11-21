@extends('layouts.app')

@section('content')
    <div class="overflow-hidden position-absolute">
        <img src="https://cdn.alibaba.ir/h/desktop/assets/images/hero/hero.jpg-c519cbc5.jpg" alt="Bus"
             class="" height="320">
    </div>
    <div class="position-absolute d-flex justify-content-center w-100" style="top:310px">
        <div class=" bg-white rounded w-75 border">
            <div class="border-bottom p-4 text-primary h4 text-center">
                {{__('bus ticket')}}
            </div>
            <form class="p-4">
                <div class="d-flex">
                    <div class="input-group input-group-lg col-5 p-0 " dir="ltr">
                        <input dir={{__('direction')}} type="text" class="form-control" placeholder={{__('destination')}} >
                        <input dir={{__('direction')}} type="text" class="form-control" placeholder={{__('origin')}} >
                    </div>
                    <div class="col-5 px-2">
                        <input type="text" class="form-control form-control-lg" placeholder="{{__('date of departure')}}" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="col-2 p-0">
                        <button class="btn btn-lg w-100" style="background-color: #FDB93C; border-color: #E3A535">{{__('search')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
