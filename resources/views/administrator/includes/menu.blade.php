<div class="topnav shadow-sm">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator') ? 'active' : '' }}"
                            href="{{ route('administrator.dashboard') }}">
                            <i class="dripicons-view-thumb me-1"></i>Dashboard <div class="arrow-right"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/tasks') || request()->is('administrator/tasks/*') ? 'active' : '' }}"
                            href="{{ route('administrator.tasks.index') }}">
                            <i class="dripicons-trophy me-1"></i>Tasks <div class="arrow-right"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/merchants') || request()->is('administrator/merchants/*') ? 'active' : '' }}"
                            href="{{ route('administrator.merchants.index') }}">
                            <i class="dripicons-store me-1"></i>Workshops <div class="arrow-right"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/drivers') || request()->is('administrator/drivers/*') ? 'active' : '' }}"
                            href="{{ route('administrator.drivers.index') }}">
                            <i class="dripicons-user me-1"></i>Drivers <div class="arrow-right"></div>
                        </a>
                    </li>
                    @if(auth()->user()->role != 'dispatcher')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/dispatchers') || request()->is('administrator/dispatchers/*') ? 'active' : '' }}"
                            href="{{ route('administrator.dispatchers.index') }}">
                            <i class="dripicons-rocket me-1"></i>Dispatchers <div class="arrow-right"></div>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/invoices') || request()->is('administrator/invoices/*') ? 'active' : '' }}"
                            href="{{ route('administrator.invoices.index') }}">
                            <i class="dripicons-document me-1"></i>Invoices <div class="arrow-right"></div>
                        </a>
                    </li>

                    @if(auth()->user()->role != 'dispatcher')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/services') || request()->is('administrator/services/*') ? 'active' : '' }}"
                            href="{{ route('administrator.services.index') }}">
                            <i class="dripicons-jewel me-1"></i>Services <div class="arrow-right"></div>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/calendar-management') || request()->is('administrator/calendar-management/*') ? 'active' : '' }}"
                            href="{{ route('administrator.calendar-management.index') }}">
                            <i class="dripicons-calendar me-1"></i>Calendar <div class="arrow-right"></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/tracking') || request()->is('administrator/tracking/*') ? 'active' : '' }}"
                            href="{{ route('administrator.tracking.index') }}">
                            <i class="dripicons-map me-1"></i>Map <div class="arrow-right"></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('administrator/pages') || request()->is('administrator/pages/*') ? 'active' : '' }}"
                            href="{{ route('administrator.pages.index') }}">
                            <i class="dripicons-rocket me-1"></i>Pages <div class="arrow-right"></div>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none {{ request()->is('administrator/my-account/*') || request()->is('administrator/change-password') || request()->is('administrator/company-details') ? 'active' : '' }}"
                            href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="dripicons-gear me-1"></i>Settings <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                            <a href="{{ route('administrator.password.form') }}" class="dropdown-item">Change
                                Password</a>
                            <a href="{{ route('administrator.my-account.edit', Auth::guard('administrator')->id()) }}"
                                class="dropdown-item">My Account</a>
                            <a href="{{ route('administrator.company-details.form') }}" class="dropdown-item">Company
                                Details</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
