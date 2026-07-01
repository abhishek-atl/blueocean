  <nav class="navbar navbar-expand-lg">
      <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">
              <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name')}} logo" height="50">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav mx-lg-auto">
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('treatments', 'treatment_detail') ? 'active' : '' }}" href="{{ route('treatments') }}">Treatments</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('therapists', 'therapist_detail') ? 'active' : '' }}" href="{{ route('therapists') }}">Therapists</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('gifts') ? 'active' : '' }}" href="{{ route('gifts') }}">Gift Cards</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('join_us') ? 'active' : '' }}" href="{{ route('join_us') }}">Join Us</a>
                  </li>
              </ul>
              <ul class="navbar-nav align-items-lg-center">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          User
                      </a>
                      <ul class="dropdown-menu dropdown-menu-lg-end">
                          @auth
                          @if(Auth::user()->hasRole('Customer'))
                          <li><a class="dropdown-item" href="{{ route('account') }}">Account</a></li>
                          <li><a class="dropdown-item" href="{{ route('bookings') }}">Bookings</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li class="px-3 py-2"><a href="{{ route('auth.logout') }}" class="btn btn-primary w-100">Logout</a></li>
                          @elseif(Auth::user()->hasRole('Therapist'))
                          <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                          <li><a class="dropdown-item" href="{{ route('bookings') }}">Bookings</a></li>
                          <li><a class="dropdown-item" href="{{ route('bookings') }}">Holidays</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li class="px-3 py-2"><a href="{{ route('auth.logout') }}" class="btn btn-primary w-100">Logout</a></li>
                          @endif
                          @endauth
                          @guest
                          <li><h6 class="dropdown-header">Already have an account?</h6></li>
                          <li class="px-3 py-2"><a href="{{ route('auth.login') }}" class="btn btn-primary w-100">Login</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><span class="dropdown-item-text">No Account?</span></li>
                          <li><a class="dropdown-item" href="{{ route('auth.register') }}">Signup Here</a></li>
                          @endguest
                      </ul>
                  </li>
                  <li class="nav-item ms-lg-3">
                      <a class="btn btn-primary {{ request()->routeIs('booking*') ? 'active' : '' }}" href="{{ route('bookingPostcode') }}">Book Now</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
  @yield('banner')
