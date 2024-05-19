@extends('frontend.layouts.app',[
"meta" => [
"title" => "Register",
]
])
@section('content')
<main>
    <div class="login-register-area section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="login-register-content ">
                            <div class="card-header login-register-title mb-30">
                                <h3>Register</h3>
                                <p>Create new account today to reap the benefits of a personalized shopping experience.
                                </p>
                            </div>
                            <div class=" card-body login-register-style">
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
                                <form method="POST">
                                    @csrf
                                    <div class="login-register-input">
                                        <label for="first_name" class="col-md-4 col-form-label text-md-right">
                                            {{  __('Full Name') }} <sub class="h6 text-danger">*</sub>
                                        </label>
                                        <input type="text" name="first_name" value="{{old('first_name')}}" wire:model="first_name" id="first_name"
                                            placeholder="Full Name" />
                                        @error('first_name')
                                        <span class="text-danger error">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="login-register-input">
                                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last
                                            Name') }}</label>
                                        <input type="text" name="last_name" value="{{old('last_name')}}" wire:model="last_name"
                                            placeholder="Last Name" />
                                        @error('last_name')
                                        <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <div class="login-register-input">
                                        <label for="mobile_number" class="col-md-4 col-form-label text-md-right">
                                            {{ __('Mobile number') }} <sub class="h6 text-danger">*</sub>
                                        </label>
                                        <input type="text" value="{{old('mobile_number')}}" name="mobile_number" placeholder="+88017****" />
                                        @error('mobile_number') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="login-register-input">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">
                                            {{ __('E-Mail Address') }}
                                        </label>
                                        <input type="email" value="{{old('email')}}" id="email" name="email" placeholder="E-mail address" />
                                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="login-register-input">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">
                                            {{ __('Password') }} <sub class="h6 text-danger">*</sub>
                                        </label>
                                        <input type="password" name="password" id="password" placeholder="*****" />
                                        @error('password')
                                        <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="login-register-input">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">
                                            {{__('Confirm Password') }} <sub class="h6 text-danger">*</sub>
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="*****" />
                                        @error('password')
                                        <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="login-register-paragraph">
                                        <p>
                                            Your personal data will be used to support your experience throughout this
                                            website, to manage access to your account, and for other purposes described
                                            in our <a href="#">privacy policy.</a>
                                        </p>
                                    </div>
                                    <div class="btn-register">
                                        <button type="submit" class="btn-register-now">Register</button>
                                    </div>
                                </form>
                                <div class="register-benefits">
                                    <h4>Sign up today and you will be able to :</h4>

                                    <ul>
                                        <li><i class="fa fa-check-circle-o"></i> Speed your way through checkout</li>
                                        <li><i class="fa fa-check-circle-o"></i> Track your orders easily</li>
                                        <li><i class="fa fa-check-circle-o"></i> Keep a record of all your purchases</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
