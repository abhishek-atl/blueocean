<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('admin.dashboard') }}">
            BlueOcean
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
                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu_therapists" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-user-nurse me-2"></i> <span class="text">Therapists</span>
                </a>
                <ul id="menu_therapists" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('admin.therapists.index') }}">Therapists</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatments.index') }}">Treatments</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu_users" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-users me-2"></i> <span class="text">Users</span>
                </a>
                <ul id="menu_users" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcode_districts.index') }}">Managers</a>
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
                <a href="#" class="@if(!Request::routeIs('admin.postcode*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_postcodes" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-envelope me-2"></i> <span class="text">Postcodes</span>
                </a>
                <ul id="menu_postcodes" class="collapse @if(Request::routeIs('admin.postcode*')) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcode_districts.index') }}" @if(Route::currentRouteName() == 'admin.postcode_districts.index') class="active" @endif>Postcode Districts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.index') }}" @if(Route::currentRouteName() == 'admin.postcodes.index' ||
                        Route::currentRouteName() == 'admin.postcodes.create' ||
                        Route::currentRouteName() == 'admin.postcodes.edit') class="active" @endif>Postcodes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcode_zones.index') }}" @if(Route::currentRouteName() == 'admin.postcode_zones.index' ||
                        Route::currentRouteName() == 'admin.postcode_zones.create' ||
                        Route::currentRouteName() == 'admin.postcode_zones.edit') class="active" @endif>Postcode Zones</a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>
</aside>
<div class="overlay"></div>