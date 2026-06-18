  <nav class="navbar navbar-expand-lg">
      <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">
              <img src="{{ asset('assets/img/logo-dark.png') }}" alt="Massagefy logo" height="50">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('treatments', 'treatment_detail') ? 'active' : '' }}" href="{{ route('treatments') }}">Treatments</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('gifts') ? 'active' : '' }}" href="{{ route('gifts') }}">Gift Cards</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('join_us') ? 'active' : '' }}" href="{{ route('join_us') }}">Join Us</a>
                  </li>
                  <li class="nav-item">
                      <a class="btn btn-primary {{ request()->routeIs('booking*') ? 'active' : '' }}" href="{{ route('bookingPostcode') }}">Book Now</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>