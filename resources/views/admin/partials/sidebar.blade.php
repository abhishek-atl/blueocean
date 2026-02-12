<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="index.html">
            <img src="{{ asset('admin/images/logo/logo.svg') }}" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home me-2"></i> <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#0" class="" data-bs-toggle="collapse" data-bs-target="#menu_therapists" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-file me-2"></i> <span class="text">Therapists</span>
                </a>
                <ul id="menu_therapists" class="collapse show dropdown-nav">
                    <li>
                        <a href="{{ route('admin.therapists.index') }}">Therapists</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatments.index') }}">Treatments</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#0" class="" data-bs-toggle="collapse" data-bs-target="#menu_users" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-file me-2"></i> <span class="text">Users</span>
                </a>
                <ul id="menu_users" class="collapse show dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcodes.districts') }}">Managers</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatments.index') }}">Customers</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}">Roles</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#0" class="" data-bs-toggle="collapse" data-bs-target="#menu_postcodes" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-file me-2"></i> <span class="text">Postcodes</span>
                </a>
                <ul id="menu_postcodes" class="collapse show dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcodes.districts') }}">Postcode Districts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.index') }}">Postcodes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.zones') }}">Postcode Zones</a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>
</aside>
<div class="overlay"></div>