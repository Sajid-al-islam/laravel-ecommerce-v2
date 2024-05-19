<div>
    {{-- Be like water. --}}
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
                                    <h3>Dashboard</h3>
                                    @if (session()->has('access_token'))
                                        <a class="btn btn-info my-3" onclick="window.location.href='/admin'">go to dashboard</a>
                                    @endif
                                    <div class="welcome">
                                        <p>
                                            Hello,
                                            <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                        </p>
                                    </div>
                                    <p class="mb-0">From your account dashboard. you can easily check &amp; view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        localStorage.setItem('token',`{{session()->get('access_token')}}`);
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
