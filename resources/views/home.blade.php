@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">{{ __('Dashboard') }}</div>

                <div class="card-body d-flex">
                    @if (session('status'))
                        <div class="alert alert-success d-flex" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in as',['role' => implode(',',array_column(Auth::user()->roles->toArray(),'name')) ]) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
