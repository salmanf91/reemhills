<div class="row">
    <div class="col-md-4 col-xs-12 left-block">
        <img src="images/login-logo.png" alt="Logo" class="logo">
        <img src="images/icon-human.png" alt="icon" class="icon-human">
        <div class="login-caption">
            <i class="fa fa-user"></i> Log In
        </div>
    </div>
    <!-- Right Block -->
    <div class="col-md-8 col-xs-12 right-block">
        <div class="login-form">
            <h2 class="form-header">Log In to Your<br/> Dashboard</h2>
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form wire:submit.prevent="login">
                @csrf
                <div class="form-group row">
                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input wire:model="username" type="email" class="form-control from-input" id="email" name="email" placeholder="Type your Email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input wire:model="password" type="password" class="form-control from-input" id="password" name="password" placeholder="Type your Password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-submit">Submit</button>
            </form>
        </div>
    </div>
</div>


