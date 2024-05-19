<div>
    <div class="login-register-area section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="login-register-content login-register-pl">
                        <div class="login-register-title mb-30">
                            <h3>Register</h3>
                            <p>Create new account today to reap the benefits of a personalized shopping experience.</p>
                        </div>
                        <div class="login-register-style">
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
                            <form method="POST" wire:submit.prevent="register_submit">
                                @csrf
                                <div class="login-register-input">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                                    <input type="text" name="first_name" wire:model="first_name" id="first_name" placeholder="First Name" />
                                    @error('first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="login-register-input">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                    <input type="text" name="last_name" wire:model="last_name" placeholder="Last Name" />
                                    @error('last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
    
                                <div class="login-register-input">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Mobile number') }}</label>
                                    <input type="number" name="phone" wire:model="phone" placeholder="+88017****" />
                                    @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
    
                                <div class="login-register-input">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <input type="email" id="email" wire:model="email" name="email" placeholder="E-mail address" />
                                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror 
                                </div>
                                <div class="login-register-input">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="password" wire:model="password" placeholder="*****" />
                                    @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="login-register-input">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" placeholder="*****" />
                                    @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                <div class="login-register-paragraph">
                                    <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#">privacy policy.</a></p>
                                </div>
                                <div class="btn-register">
                                    <button type="submit" wire:click.prevent="register_submit" class="btn-register-now">Register</button>
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
