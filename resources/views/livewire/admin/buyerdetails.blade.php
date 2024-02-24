{{-- @extends('layouts.app')

@section('content') --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="inner-page-head">Manage Resale Requests</h2>

                <div class="card">
                    <div class="card-body">
                        @if ($buyer)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="buyers_name">Buyer's Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="buyers_name" name="buyers_name" class="form-control " value="{{ $buyer->buyers_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_id" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email_id" name="email_id" class="form-control" value="{{ $buyer->email_id }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="mobile_no" name="mobile_no" class="form-control" value="{{ $buyer->mobile_no }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-3 col-form-label">Project</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="mobile_no" name="mobile_no" class="form-control" value="{{ $buyer->project }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-3 col-form-label">Phase</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="mobile_no" name="mobile_no" class="form-control" value="{{ $buyer->phase }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-3 col-form-label">Unit Number</label>
                                    <div class="col-sm-9">
                                        <input type="tel" id="unit_no" name="unit_no" class="form-control" value="{{ $buyer->unit_no }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Display passport preview if path is available -->
                                @if ($buyer->passport_path)
                                    <div class="form-group">
                                        <label class="col-sm-3 col-form-label">Download Passport Copy</label>
                                        <a href="{{ asset($buyer->passport_path) }}" download>
                                            {{-- <img src="{{ asset($buyer->passport_path) }}" alt="Passport Preview" class="preview-image"> --}}
                                            <i class="fas fa-file-pdf" style="font-size: 35px"></i>
                                        </a>
                                    </div>
                                @endif

                                <!-- Display emirates ID preview if path is available -->
                                @if ($buyer->emirates_id_path)
                                    <div class="form-group">
                                        <label class="col-sm-3 col-form-label">Download Emirates ID</label>
                                        <a href="{{ asset($buyer->emirates_id_path) }}" download>
                                            <i class="fas fa-file-pdf" style="font-size: 35px"></i>
                                        </a>
                                    </div>
                                @endif

                                <!-- Display MOU document preview if path is available -->
                                @if ($buyer->mou_doc_path)
                                    <div class="form-group">
                                        <label class="col-sm-3 col-form-label">Download MOU Document</label>
                                        <a href="{{ asset($buyer->mou_doc_path) }}" download>
                                            <i class="fas fa-file-pdf" style="font-size: 35px"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                            <p>No buyer details found for the provided ID.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


{{-- @endsection --}}
