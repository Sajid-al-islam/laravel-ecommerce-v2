<div>
    {{-- Success is as dangerous as failure. --}}
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
                                    <div class="review_section_profile">
                                        <h3>Reviews</h3>
                                        <div class="table-responsive">
                                            <table class="myaccount-table table-responsive text-center table table-bordered mt-2">
                                                
                                                <thead class="thead-light">
                                                @if (count($reviews) > 0)
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Star</th>
                                                        <th>Review</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($reviews as $key => $item)    
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $item->star }}</td>
                                                            <td>{{ Illuminate\Support\Str::limit($item->review_description, 50, '...') }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                            @php
                                                                $data = [
                                                                    "id" => $item->product->id,
                                                                    "product_name" => \Illuminate\Support\Str::slug($item->product->product_name)
                                                                ];
                                                            @endphp
                                                            <td>
                                                                <a href="{{ route('product_details', $data) }}" class="check-btn sqr-btn">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                        {{ $reviews->links() }}
                                                    @else
                                                        <b>No Review found!</b>
                                                    @endif
                                                </tbody>
                                            </table>
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
</div>
