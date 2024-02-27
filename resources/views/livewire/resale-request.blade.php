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
        {{-- <livewire:form-content :buyer-count="$buyerCount" /> --}}
        <ul  class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#national" >National</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#international" >International</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#company" >Company</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="national">
                <livewire:form-content :buyer-count="$buyerCount" :selectedTab="'national'" :key="'national'"/>
            </div>
            <div class="tab-pane fade" id="international">
                <livewire:form-content :buyer-count="$buyerCount" :selectedTab="'international'" :key="'international'"/>
            </div>
            <div class="tab-pane fade" id="company">
                <livewire:form-content :buyer-count="$buyerCount" :selectedTab="'company'" :key="'company'"/>
            </div>
        </div>

    </div>
</div>
