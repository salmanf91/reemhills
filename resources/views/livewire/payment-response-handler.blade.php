<div class="row">
    <div class="col-md-3 col-xs-12 user-left-block payment-block-left">
        <img src="{{ asset('images/login-logo.png') }}" alt="Logo" class="logo">
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
                        @if ($response == "success")
                        <p class="payment-message green">Thank you, BuyerName, your payment has been successfully processed!</p>
                        <p>We appreciate your business and will be in touch within the next 24 hours.</p>
                        @elseif ($response == "error")
                        <p class="payment-message red">Thank you, BuyerName, your payment has been rejected!</p>
                        @endif
                        <p class="payment-note">Note: Please check your email for further updates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
