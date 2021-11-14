<div class="modal fade animated fadeIn" id="loginModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-5 ">
            <div class="d-flex justify-content-end position-relative">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="position-absolute top-0 start-0">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center pb-3">
                    <h3>{{__('Login')}}</h3>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">

                        <div class="col">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{__('E-Mail Address')}}">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password" placeholder="{{__('Password')}}">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" dir="ltr">
                        <div class="col">
                            <div class="form-check float-md-right">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    <small>{{ __('Remember Me') }}</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0" dir="ltr">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>

                    <div class="form-group row mb-0" dir="ltr">
                        <div class="col">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link float-md-right" href="{{ route('password.request') }}">
                                    <small> {{ __('Forgot Your Password?') }}</small>
                                </a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
