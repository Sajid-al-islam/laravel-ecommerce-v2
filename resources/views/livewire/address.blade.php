<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
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
                                    <h3>Billing Address</h3>
                                    @if (count($address) > 0)
                                        @foreach ($address as $item)
                                        <address>
                                            <p><strong>{{ $item->first_name }} {{ $item->last_name }}</strong></p>
                                            <p>
                                                {{ $item->address }}
                                            </p>
                                            <p>Mobile: {{ $item->mobile_number }}</p>
                                        </address>
                                        <hr>
                                        @endforeach
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
