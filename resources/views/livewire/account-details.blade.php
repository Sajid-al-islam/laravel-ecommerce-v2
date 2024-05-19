<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="account-area section-space">
        <div class="container">
            <div class="myaccount-page-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include("livewire.components.account-sidebar")
                    </div>
    
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content" id="nav-tabContent">
                            
                            <div class="tab-pane fade active show" id="dashboad" role="tabpanel" aria-labelledby="dashboad-tab">
                                <div class="myaccount-content">
                                    <div>
                                        {{-- Do your work, then step back. --}}
                                        <h3>Account Details</h3>
                                        @if ($success_mssg)
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ $success_mssg }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <form class="account-details-form mt-4" action="#" wire:submit.prevent="updateUser">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="first-name" class="required">First Name</label>
                                                        <input wire:model="first_name" type="text" id="first-name" />
                                                        @error('first_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="last-name" class="required">Last Name</label>
                                                        <input wire:model="last_name"  type="text" id="last-name" />
                                                        @error('last_name') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="single-input-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="email" class="required">Email Addres</label>
                                                        <input type="email" wire:model="email" id="email" />
                                                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="phone" class="required">Mobile Number</label>
                                                        <input wire:model="phone" type="text" id="phone" />
                                                        @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="single-input-item">
                                                <button class="check-btn sqr-btn" wire:click.prevent="updateUser">Save Changes</button>
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
</div>
