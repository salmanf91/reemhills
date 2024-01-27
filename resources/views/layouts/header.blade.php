<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand col-md-2" href="#">
        <img src="images/login-logo.png" alt="Qproperties" class="dashboard-logo"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-md-10 col-sm-10 col-lg-10 col-xs-12" id="navbarNav">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side: Image -->
                <div class="col-md-4 d-flex align-items-center">
                    <img src="images/icon-male.png" alt="Qproperties" class="icon-male"/>
                    <p class="icon-male-name mb-0 ">Welcome Salman</p>
                </div>
                <!-- Right Side: Logout Button -->
                <div class="col-md-8 text-right">
                        <button wire:click="logout" class="btn btn-submit">Logout</button>
                </div>
            </div>
        </div>
    </div>
</nav>
