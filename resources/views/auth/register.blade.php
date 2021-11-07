<div class="modal fade" id="registerModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-5 ">
            <div class="d-flex justify-content-end position-relative">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true"
                                                      class="position-absolute top-0 start-0">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center pb-3">
                    <h3>{{__('Register')}}</h3>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">

                        <div class="col">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name') }}" placeholder="{{ __("Name") }}"
                                   autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __("E-Mail Address") }}" required
                                   autocomplete="email">

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
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="{{ __("Password") }}" required
                                   autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col">
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   placeholder="{{__("Confirm Password")}}" required
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
