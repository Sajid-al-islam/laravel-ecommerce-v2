<div>
    <div class="login-register-area section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header p-4">
                            <div class="login-register-title mb-30">
                                <h3>Login</h3>
                                <p>Welcome back! Please enter your email and password to login from.</p>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="login-register-content">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="login-register-style">
                                    <form method="POST" wire:submit.prevent="login">
                                        @csrf
                                        <div class="login-register-input">
                                            <label for="email" class="col-md col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email" name="email" wire:model="email" class="@error('email') is-invalid @enderror" placeholder="Username or email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="login-register-input">
                                            <label for="password" class="col-md col-form-label text-md-right">{{ __('Password') }}</label>
                                            <input id="password" type="password" wire:model="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="remember-me-btn">
                                            <input id="remember-me-checkbox" type="checkbox">
                                            <label for="remember-me-checkbox">Remember me</label>

                                        </div> --}}
                                        <div class="form-group row">
                                            <div class="">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0 mt-2">
                                            <div class="">
                                                <button type="submit"  wire:click.prevent="login" class="btn-register-now">
                                                    {{ __('Login') }}
                                                </button>

                                                @if (Route::has('password.request'))
                                                    <br>
                                                    <a class="pt-2" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="btn-register">
                                            Dont have an account? <a href="{{ route('website_register') }}"><b>Register now</b></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
