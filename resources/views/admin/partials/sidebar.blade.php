<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('admin.dashboard') }}">
            BlueOcean
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item @if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home me-2"></i> <span class="text">Dashboard</span>
                </a>
            </li>

            @can('Therapist Management')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.therapists*') &&
                !Request::routeIs('admin.treatments*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_therapists" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-user-nurse me-2"></i> <span class="text">Therapists</span>
                </a>
                <ul id="menu_therapists" class="collapse @if(Request::routeIs('admin.therapists*') ||
                    Request::routeIs('admin.treatments*')
                    ) show @endif dropdown-nav">

                    <li>
                        <a href="{{ route('admin.therapists.index') }}" @if(Route::currentRouteName()=='admin.therapists.index' ||
                        Route::currentRouteName()=='admin.therapists.create' ||
                        Route::currentRouteName()=='admin.therapists.edit' ||
                        Route::currentRouteName()=='admin.therapists.profile' ||
                        Route::currentRouteName()=='admin.therapists.treatments' ||
                        Route::currentRouteName()=='admin.therapists.postcodes' ||
                        Route::currentRouteName()=='admin.therapists.schedules' ||
                        Route::currentRouteName()=='admin.therapists.fees' ||
                        Route::currentRouteName()=='admin.therapists.holidays' ) class="active" @endif>Therapists</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatments.index') }}" @if(Route::currentRouteName()=='admin.treatments.index' ||
                        Route::currentRouteName()=='admin.treatments.create' ||
                        Route::currentRouteName()=='admin.treatments.edit') class="active" @endif>Treatments</a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.customers*') &&
                !Request::routeIs('admin.users*') &&
                !Request::routeIs('admin.roles*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_users" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-users me-2"></i> <span class="text">Users</span>
                </a>
                <ul id="menu_users" class="collapse @if(Request::routeIs('admin.users*') ||
                Request::routeIs('admin.customers*') ||
                Request::routeIs('admin.roles*')) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.users.index') }}"  @if(Route::currentRouteName()=='admin.users.index' ||
                        Route::currentRouteName()=='admin.users.create' ||
                        Route::currentRouteName()=='admin.users.edit' ) class="active" @endif>Admins</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}"  @if(Route::currentRouteName()=='admin.customers.index' ||
                        Route::currentRouteName()=='admin.customers.create' ||
                        Route::currentRouteName()=='admin.customers.edit' ) class="active" @endif>Customers</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}" @if(Route::currentRouteName()=='admin.roles.index' ||
                        Route::currentRouteName()=='admin.roles.create' ||
                        Route::currentRouteName()=='admin.roles.edit' ) class="active" @endif>Roles</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.postcode*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_postcodes" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-envelope me-2"></i> <span class="text">Postcodes</span>
                </a>
                <ul id="menu_postcodes" class="collapse @if(Request::routeIs('admin.postcode*')) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcode_districts.index') }}" @if(Route::currentRouteName()=='admin.postcode_districts.index' ) class="active" @endif>Postcode Districts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.index') }}" @if(Route::currentRouteName()=='admin.postcodes.index' || Route::currentRouteName()=='admin.postcodes.create' || Route::currentRouteName()=='admin.postcodes.edit' ) class="active" @endif>Postcodes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcode_zones.index') }}" @if(Route::currentRouteName()=='admin.postcode_zones.index' || Route::currentRouteName()=='admin.postcode_zones.create' || Route::currentRouteName()=='admin.postcode_zones.edit' ) class="active" @endif>Postcode Zones</a>
                    </li>

                </ul>
            </li>

             <li class="nav-item">
                <a href="{{ route('auth.logout') }}">
                    <i class="fa fa-home me-2"></i> <span class="text">Logout</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>
<div class="overlay"></div>