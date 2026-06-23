<form method="post" action="{{ route('post-register') }}" id="postRegisterForm">

    @csrf
    <input type="hidden" name="bookingId" value="{{ isset($bookingId) ? $bookingId : ''  }}" />

    <div class="row g-4">

        <div class="col-12">
            <label class="form-label" for="register_name">Name</label>
            <input type="text" class="form-control" id="register_name" name="name" placeholder="Your name" required value="{{ old('name') }}">
            @error('name')
            <span class="help-block error-help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label" for="register_email">Email</label>
            <input type="email" class="form-control" id="register_email" name="email" placeholder="you@example.com" required value="{{ old('email') }}">
            @error('email')
            <span class="help-block error-help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label" for="register_password">Password</label>
            <input type="password" class="form-control" id="register_password" name="password" placeholder="Choose a password" required>
            @error('password')
            <span class="help-block error-help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label" for="password_confirmation">Confirm password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
            @error('password_confirmation')
            <span class="help-block error-help-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            <button class="btn btn-primary btn-block submit" type="submit">Register</button>
        </div>

    </div>

</form>