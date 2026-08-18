<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('admin/img/logo.png') }}" alt="logo" class="img-fluid">
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
                <a href="#" class="@if(
                !Request::routeIs('admin.bookings*') &&
                !Request::routeIs('admin.payments*')) 
                collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_bookings" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-wallet me-2"></i> <span class="text">Bookings</span>
                </a>
                <ul id="menu_bookings" class="collapse @if(Request::routeIs('admin.bookings*') ||
                    Request::routeIs('admin.payments*')
                    ) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.bookings.index') }}" @if(Request::routeIs('admin.bookings*')) class="active" @endif>Bookings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payments.index') }}" @if(Request::routeIs('admin.payments*')) class="active" @endif>Payments</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Therapist')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(
                !Request::routeIs('admin.therapists*') &&
                !Request::routeIs('admin.therapist_applications*') &&
                !Request::routeIs('admin.therapy_kits*') &&
                !Request::routeIs('admin.treatment*')) 
                collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_therapists" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-user-nurse me-2"></i> <span class="text">Therapists</span>
                </a>
                <ul id="menu_therapists" class="collapse @if(
                    Request::routeIs('admin.therapists*') ||
                    Request::routeIs('admin.therapist_applications*') ||
                    Request::routeIs('admin.therapy_kits*') ||
                    Request::routeIs('admin.treatment*'))
                    show @endif dropdown-nav">

                    <li>
                        <a href="{{ route('admin.therapists.index') }}" @if(Request::routeIs('admin.therapists*')) class="active" @endif>
                            Therapists
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.therapist_applications.index') }}" @if(Request::routeIs('admin.therapist_applications*')) class="active" @endif>
                            Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatments.index') }}" @if(Request::routeIs('admin.treatments*')) class="active" @endif>
                            Treatments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.therapy_kits.index') }}" @if(Request::routeIs('admin.therapy_kits*')) class="active" @endif>
                            Therapy Kits
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.treatment_categories.index') }}" @if(Request::routeIs('admin.treatment_categories*')) class="active" @endif>
                            Treatment Categories
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage User')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(
                !Request::routeIs('admin.customers*') &&
                !Request::routeIs('admin.users*') &&
                !Request::routeIs('admin.roles*') && 
                !Request::routeIs('admin.blacklists*')
                ) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_users" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-users me-2"></i> <span class="text">Users</span>
                </a>
                <ul id="menu_users" class="collapse @if(
                Request::routeIs('admin.users*') ||
                Request::routeIs('admin.customers*') ||
                Request::routeIs('admin.roles*') ||
                Request::routeIs('admin.blacklists*')
                ) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.users.index') }}" @if(Request::routeIs('admin.users*')) class="active" @endif>
                            Admins
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}" @if(Request::routeIs('admin.customers*')) class="active" @endif>
                            Customers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}" @if(Request::routeIs('admin.roles*')) class="active" @endif>
                            Roles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blacklists.index') }}" @if(Request::routeIs('admin.blacklists*')) class="active" @endif>
                            Blacklists
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Setting')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(
                !Request::routeIs('admin.postcode_districts*') &&
                !Request::routeIs('admin.postcodes*') &&
                !Request::routeIs('admin.tariff_plans*') &&
                !Request::routeIs('admin.gift_certificates*') &&
                !Request::routeIs('admin.promocodes*') &&
                !Request::routeIs('admin.settings*'))
                collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_postcodes" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-gear me-2"></i> <span class="text">Settings</span>
                </a>
                <ul id="menu_postcodes" class="collapse @if(
                Request::routeIs('admin.postcode_districts*') ||
                Request::routeIs('admin.postcodes*') ||
                Request::routeIs('admin.tariff_plans*') ||
                Request::routeIs('admin.gift_certificates*') ||
                Request::routeIs('admin.promocodes*') ||
                Request::routeIs('admin.settings*'))
                show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.settings.index') }}" @if(Request::routeIs('admin.settings*')) class="active" @endif>
                            General Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcode_districts.index') }}" @if(Request::routeIs('admin.postcode_districts*')) class="active" @endif>
                            Postcode Districts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.postcodes.index') }}" @if(Request::routeIs('admin.postcodes*')) class="active" @endif>
                            Postcodes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tariff_plans.index') }}" @if(Request::routeIs('admin.tariff_plans*')) class="active" @endif>
                            Tariff Plans
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.promocodes.index') }}" @if(Request::routeIs('admin.promocodes*')) class="active" @endif>
                            Promocodes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gift_certificates.index') }}" @if(Request::routeIs('admin.gift_certificates*')) class="active" @endif>
                            Gift Certificates
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('Manage Content')
            <li class="nav-item nav-item-has-children">
                <a href="#" class="@if(
                !Request::routeIs('admin.reviews*') &&
                !Request::routeIs('admin.faqs*') &&
                !Request::routeIs('admin.banners*') &&
                !Request::routeIs('admin.posts*') &&
                !Request::routeIs('admin.post_tags*'))
                collapsed @endif" data-bs-toggle="collapse" data-bs-target="#menu_content" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-paste me-2"></i> <span class="text">Content</span>
                </a>
                <ul id="menu_content" class="collapse @if(
                    Request::routeIs('admin.reviews*') ||
                    Request::routeIs('admin.faqs*') ||
                    Request::routeIs('admin.banners*') ||
                    Request::routeIs('admin.posts*') ||
                    Request::routeIs('admin.post_tags*')
                    ) show @endif dropdown-nav">
                    <li>
                        <a href="{{ route('admin.reviews.index') }}" @if(Request::routeIs('admin.reviews*')) class="active" @endif>
                            Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.index') }}" @if(Request::routeIs('admin.faqs*')) class="active" @endif>
                            FAQs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.banners.index') }}" @if(Request::routeIs('admin.banners*')) class="active" @endif>
                            Banners
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" @if(Request::routeIs('admin.posts*')) class="active" @endif>
                            Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.post_tags.index') }}" @if(Request::routeIs('admin.post_tags*')) class="active" @endif>
                            Post Tags
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="nav-item">
                <a href="{{ route('auth.logout',['user' => 'admin']) }}">
                    <i class="fa fa-arrow-right-from-bracket me-2"></i> <span class="text">Logout</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>
<div class="overlay"></div>
