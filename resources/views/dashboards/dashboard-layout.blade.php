@extends('layouts.app')

@section('content')
    <div class="container m-5">
        <div class="row justify-content-center ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            @yield('dashboard-title')
                        </div>
                        <div>
                            <a href="{{url()->previous()}}"><img src="https://img.icons8.com/metro/15/000000/back.png"/></a>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column">
                        @if (session('status'))
                            <div class="alert alert-success d-flex" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
{{--                        {{ __('You are logged in as',['role' => implode(',',array_column(Auth::user()->roles->toArray(),'name')) ]) }}--}}
                        @yield('inner-content')

                        @can('companyGate')
                            {{--                            @include('dashboards.company')--}}
                        @endcan

                        @can('superAdminGate')
                            {{--                            @include('dashboards.superuser')--}}
                        @endcan

                        @auth
                            {{--                            @include('dashboards.user')--}}
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
