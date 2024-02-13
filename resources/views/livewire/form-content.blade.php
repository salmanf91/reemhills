<!-- resources/views/livewire/user-form.blade.php -->

<div>
    <div class="user-form">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form wire:submit.prevent="submit">
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

                    @if($selectedTab == 'company')

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
                    @endif

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
                        <div class="col-sm-9 offset-sm-3">
                            <button type="button" wire:click="addBuyer" class="btn btn-success">Add Buyer {{ $buyerCount + 1 }}</button>
                        </div>
                    </div>

                    @foreach ($buyers as $index => $buyer)
                        @if ($loop->index >= 1)
                        <div wire:key="secondary-buyer-{{ $index }}">
                            <div class="form-group row">
                                <label for="buyers_name_{{ $index }}" class="col-sm-3 col-form-label">Buyer's Name</label>
                                <div class="col-sm-9">
                                    <input wire:model="buyers.{{ $index }}.name" type="text" class="form-control from-input" id="buyers_name_{{ $index }}" name="buyers_name[]" placeholder="Type Buyer's Name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="buyers_mobile_{{ $index }}" class="col-sm-3 col-form-label">Mobile Number</label>
                                <div class="col-sm-9">
                                    <input wire:model="buyers.{{ $index }}.mobile_no" type="tel" class="form-control from-input" id="buyers_mobile_{{ $index }}" name="buyers_mobile_no[]" placeholder="Type Mobile Number" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="buyers_email_{{ $index }}" class="col-sm-3 col-form-label">Email ID</label>
                                <div class="col-sm-9">
                                    <input wire:model="buyers.{{ $index }}.email_id" type="email" class="form-control from-input" id="buyers_email_{{ $index }}" name="buyers_email_id[]" placeholder="Type Email ID" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="buyers_address_{{ $index }}" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea wire:model="buyers.{{ $index }}.address" class="form-control from-input" id="buyers_address_{{ $index }}" name="buyers_address[]" placeholder="Type Address" required></textarea>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>


                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="project" class="col-sm-3 col-form-label">Project</label>
                        <div class="col-sm-9">
                            <select wire:model="project" class="form-control from-select" id="project" name="project" required>
                                <option value="">Select Project</option>
                                <option value="project1">Project 1</option>
                                <option value="project2">Project 2</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phase" class="col-sm-3 col-form-label">Phase</label>
                        <div class="col-sm-9">
                            <select wire:model="phase" class="form-control from-select" id="phase" name="phase" required>
                                <option value="">Select Phase</option>
                                <option value="phase1">Phase 1</option>
                                <option value="phase2">Phase 2</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="unit_no" class="col-sm-3 col-form-label">Unit Number</label>
                        <div class="col-sm-9">
                            <input wire:model="unit_no" type="text" class="form-control from-input" id="unit_no" name="unit_no" placeholder="123456" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passport_copy" class="col-sm-3 col-form-label">Passport Copy</label>
                        <div class="col-sm-9">
                            <input wire:model="passport_copy" type="file" class="form-control from-input form-file" id="passport_copy" name="passport_copy" required>
                        </div>
                    </div>

                    @if($selectedTab == 'national' || $selectedTab == 'company')
                    <!-- Render Emirates ID input for National and Company tabs -->
                    <div class="form-group row">
                        <label for="emirates_id" class="col-sm-3 col-form-label">Emirates ID</label>
                        <div class="col-sm-9">
                            <input wire:model="emirates_id" type="file" class="form-control from-input form-file" id="emirates_id" name="emirates_id" required>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label for="mou_document" class="col-sm-3 col-form-label">MOU Document</label>
                        <div class="col-sm-9">
                            <input wire:model="mou_document" type="file" class="form-control from-input form-file" id="mou_document" name="mou_document" required>
                        </div>
                    </div>

                    @if($selectedTab == 'company')
                    <!-- Render TL Number and Trade Licence inputs for Company tab -->
                    <div class="form-group row">
                        <label for="trade_license" class="col-sm-3 col-form-label">Trade Licence</label>
                        <div class="col-sm-9">
                            <input wire:model="company_trade_license" type="file" class="form-control from-input form-file" id="trade_licence" name="trade_licence" required>
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

