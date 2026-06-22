<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="img-fluid">
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item @if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-home me-2"></i> <span class="text">Dashboard</span>
                </a>
            </li>

            @can('Manage Booking')
             <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.bookings*') &&
                !Request::routeIs('admin.payments*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_bookings" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-wallet me-2"></i> <span class="text">Bookings</span>
                </a>
                <ul id="menu_bookings" class="collapse @if(Request::routeIs('admin.bookings*') ||
                    Request::routeIs('admin.payments*')
                    ) show @endif dropdown-nav">

                    <li>
                        <a href="{{ route('admin.bookings.index') }}" @if(
                            Route::currentRouteName()=='admin.bookings.index' ||
                            Route::currentRouteName()=='admin.bookings.create' ||
                            Route::currentRouteName()=='admin.bookings.edit') class="active" @endif>Bookings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payments.index') }}" @if(
                            Route::currentRouteName()=='admin.payments.index' ||
                            Route::currentRouteName()=='admin.payments.create' ||
                            Route::currentRouteName()=='admin.payments.edit') class="active" @endif>Payments</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Therapist')
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

            @can('Manage User')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.customers*') &&
                !Request::routeIs('admin.users*') &&
                !Request::routeIs('admin.roles*')
                ) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_users" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-users me-2"></i> <span class="text">Users</span>
                </a>
                <ul id="menu_users" class="collapse @if(Request::routeIs('admin.users*') ||
                Request::routeIs('admin.customers*') ||
                Request::routeIs('admin.roles*')
                ) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.users.index') }}" @if(Route::currentRouteName()=='admin.users.index' ||
                        Route::currentRouteName()=='admin.users.create' || Route::currentRouteName()=='admin.users.edit' ) class="active" @endif>Admins</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}" @if(Route::currentRouteName()=='admin.customers.index' ||
                        Route::currentRouteName()=='admin.customers.create' ||
                        Route::currentRouteName()=='admin.customers.edit' ) class="active" @endif>Customers</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}" @if(Route::currentRouteName()=='admin.roles.index' ||
                        Route::currentRouteName()=='admin.roles.create' ||
                        Route::currentRouteName()=='admin.roles.edit' ||
                        Route::currentRouteName()=='admin.roles.permissions') class="active" @endif>Roles</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blacklists.index') }}" @if(Route::currentRouteName()=='admin.blacklists.index' ||
                        Route::currentRouteName()=='admin.blacklists.create' ||
                        Route::currentRouteName()=='admin.blacklists.edit' ) class="active" @endif>Blacklists</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Setting')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.postcode*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_postcodes" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-envelope me-2"></i> <span class="text">Postcodes</span>
                </a>
                <ul id="menu_postcodes" class="collapse @if(Request::routeIs('admin.postcode*')) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.postcode_districts.index') }}" @if(Route::currentRouteName()=='admin.postcode_districts.index' ) class="active" @endif>Postcode Districts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.index') }}" @if(Route::currentRouteName()=='admin.postcodes.index' ||
                        Route::currentRouteName()=='admin.postcodes.create' ||
                        Route::currentRouteName()=='admin.postcodes.edit' ) class="active" @endif>Postcodes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcode_zones.index') }}" @if(Route::currentRouteName()=='admin.postcode_zones.index' ||
                        Route::currentRouteName()=='admin.postcode_zones.create' ||
                        Route::currentRouteName()=='admin.postcode_zones.edit' ) class="active" @endif>Postcode Zones</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tariff_plans.index') }}" @if(Route::currentRouteName()=='admin.tariff_plans.index' ||
                        Route::currentRouteName()=='admin.tariff_plans.create' ||
                        Route::currentRouteName()=='admin.tariff_plans.edit' ) class="active" @endif>Tariff Plans</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gift_certificates.index') }}" @if(Route::currentRouteName()=='admin.gift_certificates.index' ||
                        Route::currentRouteName()=='admin.gift_certificates.create' ||
                        Route::currentRouteName()=='admin.gift_certificates.edit' ) class="active" @endif>Gift Certificates</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Content')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(!Request::routeIs('admin.post*')) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_posts" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-envelope me-2"></i> <span class="text">Content</span>
                </a>
                <ul id="menu_posts" class="collapse @if(Request::routeIs('admin.post*')) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.post_tags.index') }}" @if(Route::currentRouteName()=='admin.post_tags.index' ||
                        Route::currentRouteName()=='admin.post_tags.create' ||
                        Route::currentRouteName()=='admin.post_tags.edit' ) class="active" @endif>Post Tags</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" @if(Route::currentRouteName()=='admin.posts.index' ||
                        Route::currentRouteName()=='admin.posts.create' ||
                        Route::currentRouteName()=='admin.posts.edit' ) class="active" @endif>Posts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.post_comments.index') }}" @if(Route::currentRouteName()=='admin.post_comments.index' ||
                        Route::currentRouteName()=='admin.post_comments.create' ||
                        Route::currentRouteName()=='admin.post_comments.edit' ) class="active" @endif>Post Comments</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reviews.index') }}" @if(Route::currentRouteName()=='admin.reviews.index' ||
                        Route::currentRouteName()=='admin.reviews.create' ||
                        Route::currentRouteName()=='admin.reviews.edit' ) class="active" @endif>Reviews</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.index') }}" @if(Route::currentRouteName()=='admin.faqs.index' ||
                        Route::currentRouteName()=='admin.faqs.create' ||
                        Route::currentRouteName()=='admin.faqs.edit' ) class="active" @endif>FAQs</a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="nav-item">
                <a href="{{ route('auth.logout',['user' => 'admin']) }}">
                    <i class="fa fa-home me-2"></i> <span class="text">Logout {{ Auth::user()->first_name }}</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>
<div class="overlay"></div>