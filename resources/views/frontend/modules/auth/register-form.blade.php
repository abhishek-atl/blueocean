<form class="mt-3 mb-3 login-input" method="post" action="" id="postRegisterForm">
    @csrf
    <input type="hidden" name="bookingId" value="{{ isset($bookingId) ? $bookingId : ''  }}" />
    <div class="form-row">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{ isset($name) ? $name : '' }}">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required value="{{ isset($email) ? $email : '' }}">
        </div>
        <div class="form-group col-md-12">
            <input type="password" class="form-control" id="passsword" name="password" placeholder="Choose a Password" required>
        </div>
        <div class="form-group col-md-12">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Verify Password" required>
        </div>
    </div>
    <div class="mt-2 mb-3">
        <button class="btn btn-primary btn-block submit" type="submit">Let's Go</button>
    </div>
</form>