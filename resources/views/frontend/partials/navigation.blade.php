  <nav class="navbar navbar-expand-lg">
      <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">
              <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name')}} logo" height="50">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link hover-effect {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link hover-effect {{ request()->routeIs('treatments', 'treatment_detail') ? 'active' : '' }}" href="{{ route('treatments') }}">Treatments</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link hover-effect {{ request()->routeIs('therapists', 'therapist_detail') ? 'active' : '' }}" href="{{ route('therapists') }}">Therapists</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link hover-effect {{ request()->routeIs('gifts') ? 'active' : '' }}" href="{{ route('gifts') }}">Gift Cards</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link hover-effect {{ request()->routeIs('join_us') ? 'active' : '' }}" href="{{ route('join_us') }}">Join Us</a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle btn-user-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-user"></i>
                      </a>
                      <i class="fa fa-chevron-down arrow-down"></i>
                      <ul class="dropdown-menu btn-user">
                          @auth
                          @if(Auth::user()->hasRole('Customer'))
                          <div class="p-3 text-center">
                              <p><a href="{{ route('account') }}">Account</a></p>
                              <p><a href="{{ route('bookings') }}">Bookings</a></p>
                              <hr />
                              <p><a href="{{ route('auth.logout') }}" class="btn btn-primary">Logout</a></p>
                          </div>
                          @elseif(Auth::user()->hasRole('Therapist'))
                          <div class="p-3 text-center">
                              <p><a href="{{ route('profile') }}">Profile</a></p>
                              <p><a href="{{ route('bookings') }}">Bookings</a></p>
                              <p><a href="{{ route('bookings') }}">Holidays</a></p>
                              <hr />
                              <p><a href="{{ route('auth.logout') }}" class="btn btn-primary">Logout</a></p>
                          </div>
                          @endif
                          @endauth
                          @guest
                          <div class="p-3 text-center">
                              <p>Already have an account?</p>
                              <p><a href="{{ route('auth.login') }}" class="btn btn-primary">Login</a></p>
                              <hr />
                              <p>No Account? <a href="{{ route('auth.register') }}">Signup Here</a></p>
                          </div>
                          @endguest
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a class="btn btn-primary {{ request()->routeIs('booking*') ? 'active' : '' }}" href="{{ route('bookingPostcode') }}">Book Now</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
  @yield('banner')