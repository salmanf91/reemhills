<div class="row">
    <div class="col-md-3 col-xs-12 user-left-block payment-block-left">
        <img src="images/login-logo.png" alt="Logo" class="logo">
        <div class="user-caption">
            <h1>Thank you </h1>
            <p>We are here<br/>to hear you</p>
        </div>
    </div>

    <div class="col-md-9 col-xs-12 user-right-block">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="national">
                <div>
                    <div class="user-form payment-block-right">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h1 class="payment-head">Payment Confirmation</h1>
                        <p class="payment-message">Thank you, BuyerName, your payment has been successfully processed!</p>
                        <p>We appreciate your business and will be in touch within the next 24 hours.</p>
                        <p class="payment-note">Note: Please check your email for further updates.</p>
                        {{-- <form wire:submit.prevent="submit">
                            @csrf
                            <div class="form-group row" wire:key="buyer-content">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="primary_buyer_name" class="col-sm-3 col-form-label">Buyer's Name</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.name" type="text" class="form-control from-input" id="primary_buyer_name" name="buyers_name[]"
                                            placeholder="Type the Buyer's Name" required>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="primary_dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.dob" type="date" class="form-control from-input" id="primary_dob" name="primary_dob" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <!-- Radio buttons for gender -->
                                            <div class="form-check form-check-inline">
                                                <input wire:model="buyers.0.gender" class="form-check-input" type="radio" id="primary_gender_male" name="primary_gender_male" value="Male">
                                                <label class="form-check-label" for="gender_male_primary">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input wire:model="buyers.0.gender" class="form-check-input" type="radio" id="primary_gender_female" name="primary_gender_female" value="Female">
                                                <label class="form-check-label" for="gender_female_primary">Female</label>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="company_name" class="col-sm-3 col-form-label">Company Name</label>
                                        <div class="col-sm-9">
                                            <input wire:model="company_name" type="text" class="form-control from-input" id="company_name" name="company_name" placeholder="Type Company Name" required>
                                        </div>
                                    </div>

                                    <!-- Render TL Number and Trade Licence inputs for Company tab -->
                                    <div class="form-group row">
                                        <label for="tl_no" class="col-sm-3 col-form-label">TL Number</label>
                                        <div class="col-sm-9">
                                            <input wire:model="company_tl_no" type="text" class="form-control from-input" id="tl_no" name="tl_no" placeholder="Type TL Number" required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="primary_buyer_mobile" class="col-sm-3 col-form-label">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.mobile_no" type="number" class="form-control from-input" id="primary_buyer_mobile" name="buyers_mobile_no[]"
                                            placeholder="Type Mobile Number" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="primary_buyer_email" class="col-sm-3 col-form-label">Email ID</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.email_id" type="email" class="form-control from-input" id="primary_buyer_email" name="buyers_email_id[]"
                                            placeholder="Type Email ID" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="primary_buyer_address" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea wire:model="buyers.0.address" class="form-control from-input" id="primary_buyer_address" name="buyers_address[]"
                                            placeholder="Type Address" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="primary_country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <!-- Replace input text with select if needed -->
                                            <input wire:model="buyers.0.country" type="text" class="form-control from-input" id="primary_country" name="primary_country" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="primary_passport_number" class="col-sm-3 col-form-label">Passport Number</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.passport_number" type="text" class="form-control from-input" id="primary_passport_number" name="primary_passport_number" required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="primary_emirates_id" class="col-sm-3 col-form-label">Emirates ID</label>
                                        <div class="col-sm-9">
                                            <input wire:model="buyers.0.emirates_id" type="text" class="form-control from-input" id="primary_emirates_id" name="primary_emirates_id" required>
                                        </div>
                                    </div>





                                </div>


                                <div class="col-md-6">

                                    <div class="form-group row">
                                        <label for="passport_copy" class="col-sm-3 col-form-label">Passport Copy</label>
                                        <div class="col-sm-9">
                                            <input wire:model="passport_copy" type="file" class="form-control from-input form-file" id="passport_copy" name="passport_copy" required>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="mou_document" class="col-sm-3 col-form-label">MOU Document</label>
                                        <div class="col-sm-9">
                                            <input wire:model="mou_document" type="file" class="form-control from-input form-file" id="mou_document" name="mou_document" required>
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
