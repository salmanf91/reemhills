<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="inner-page-head">Manage Amounts </h2>
            <div class="card admin-list">
                <div class="card-body">
                    <div class="user-form admin-form">
                        @if($amountId)
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form wire:submit.prevent="storeAmount">
                                @csrf
                                <div class="form-group row" wire:key="buyer-content">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-3 col-form-label">Update Amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="amount" wire:model.defer="amount" placeholder="Enter Amount">
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-submit">Update</button>


                                    </div>


                                    <div class="col-md-6">

                                        @if(session()->has('success'))
                                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                        @endif
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                        @endif

                                        <div class="form-group row">

                                            <div class="col-md-12">
                                                <p style="text-align:center; font-size:20px;">The amount has been updated to {{ $amount }}.</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        @else
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form wire:submit.prevent="storeAmount">
                                @csrf
                                <div class="form-group row" wire:key="buyer-content">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-3 col-form-label">Enter Amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="amount" wire:model.defer="amount" placeholder="Enter Amount">
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-submit">Save</button>
                                    </div>

                                    <div class="col-md-6">
                                        @if(session()->has('success'))
                                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                        @endif
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                        @endif
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <p style="text-align:center; font-size:20px;">Please provide the amount as it is currently not set.</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
