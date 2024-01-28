<div class="row">
    <div class="col-md-3 col-xs-12 user-left-block">
        <img src="images/login-logo.png" alt="Logo" class="logo">
        <div class="user-caption">
            <h1>Let's get <br/>you setup </h1>
            <p>It should only take a <br/>couple of minutes</p>
        </div>
        <div class="sign-in">
            <button type="button" wire:click="adminSignIn" class="btn btn-primary">Sign In</button>
        </div>
    </div>

    <div class="col-md-9 col-xs-12 user-right-block">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a wire:click="changeTab('national')" class="nav-link {{ $activeTab === 'national' ? 'active' : '' }}" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">National</a>
            </li>
            <li class="nav-item" role="presentation">
              <a wire:click="changeTab('international')" class="nav-link {{ $activeTab === 'international' ? 'active' : '' }}" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">International</a>
            </li>
            <li class="nav-item" role="presentation">
              <a wire:click="changeTab('company')" class="nav-link {{ $activeTab === 'company' ? 'active' : '' }}" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Company</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show {{ $activeTab === 'national' ? 'active' : '' }}" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @livewire('tab-national', ['buyerCount' => $buyerCount])
            </div>
            <div class="tab-pane fade {{ $activeTab === 'international' ? 'active' : '' }}" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @livewire('tab-international', ['buyerCount' => $buyerCount])
            </div>
            <div class="tab-pane fade {{ $activeTab === 'company' ? 'active' : '' }}" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                @livewire('tab-company', ['buyerCount' => $buyerCount])
            </div>
          </div>

    </div>
</div>
