<div class="leftside-menu">

    <!-- LOGO -->
    <a href="{{ route('administrator.dashboard') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo-sm.png') }}" alt="" height="44">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ route('administrator.dashboard') }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item {{ request()->is('administrator') ? 'menuitem-active' : '' }}">
                <a href="{{ route('administrator.dashboard') }}" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 36 36">
                        <path fill="currentColor"
                            d="M15.85 18.69a3 3 0 1 0 4.83.85l5.92-5.81l-1.41-1.41l-5.91 5.81a3 3 0 0 0-3.43.56Z"
                            class="clr-i-outline--badged clr-i-outline-path-1--badged" />
                        <path fill="currentColor"
                            d="M32.58 13a7.45 7.45 0 0 1-2.06.44a14.4 14.4 0 0 1 1.93 6.43h-3.53v2h3.53a14.43 14.43 0 0 1-3.11 7.84H6.66a14.43 14.43 0 0 1-3.11-7.84H7v-2H3.55A14.41 14.41 0 0 1 7 11.29l2.45 2.45l1.41-1.41l-2.43-2.46A14.41 14.41 0 0 1 17 6.29v3.5h2V6.3a14.41 14.41 0 0 1 3.58.7a7.52 7.52 0 0 1-.08-1a7.52 7.52 0 0 1 .09-1.09A16.49 16.49 0 0 0 5.4 31.4l.3.35h24.6l.3-.35a16.45 16.45 0 0 0 2-18.36Z"
                            class="clr-i-outline--badged clr-i-outline-path-2--badged" />
                        <circle cx="30" cy="6" r="5" fill="currentColor"
                            class="clr-i-outline--badged clr-i-outline-path-3--badged clr-i-badge" />
                        <path fill="none" d="M0 0h36v36H0z" />
                    </svg>
                    <span> Dashboard </span>
                </a>
            </li>
            <li
                class="side-nav-item {{ request()->is('administrator/merchants') || request()->is('administrator/merchants/*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('administrator.merchants.index') }}" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m20.772 13.155l-1.368-4.104A2.995 2.995 0 0 0 16.559 7H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.104A2.001 2.001 0 0 0 2 15v3c0 .738.404 1.376 1 1.723V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.277A1.99 1.99 0 0 0 22 18v-3c0-.831-.507-1.542-1.228-1.845zM7.441 9h9.117a1 1 0 0 1 .949.684L18.613 13H5.387l1.105-3.316c.137-.409.519-.684.949-.684zM5.5 18a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 5.5 18zm13 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18.5 18zM5.277 5c.347.595.985 1 1.723 1s1.376-.405 1.723-1h6.555c.346.595.984 1 1.722 1s1.376-.405 1.723-1H17V3h1.723c-.347-.595-.985-1-1.723-1s-1.376.405-1.723 1H8.723C8.376 2.405 7.738 2 7 2s-1.376.405-1.723 1H7v2H5.277z" />
                    </svg>
                    <span> Workshops </span>
                </a>
            </li>
            <li
                class="side-nav-item {{ request()->is('administrator/tasks') || request()->is('administrator/tasks/*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('administrator.tasks.index') }}" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m20.772 13.155l-1.368-4.104A2.995 2.995 0 0 0 16.559 7H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.104A2.001 2.001 0 0 0 2 15v3c0 .738.404 1.376 1 1.723V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.277A1.99 1.99 0 0 0 22 18v-3c0-.831-.507-1.542-1.228-1.845zM7.441 9h9.117a1 1 0 0 1 .949.684L18.613 13H5.387l1.105-3.316c.137-.409.519-.684.949-.684zM5.5 18a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 5.5 18zm13 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18.5 18zM5.277 5c.347.595.985 1 1.723 1s1.376-.405 1.723-1h6.555c.346.595.984 1 1.722 1s1.376-.405 1.723-1H17V3h1.723c-.347-.595-.985-1-1.723-1s-1.376.405-1.723 1H8.723C8.376 2.405 7.738 2 7 2s-1.376.405-1.723 1H7v2H5.277z" />
                    </svg>
                    <span> Tasks </span>
                </a>
            </li>
            <li
                class="side-nav-item {{ request()->is('administrator/drivers') || request()->is('administrator/drivers/*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('administrator.drivers.index') }}" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M1 16v-2q0-.425.288-.713T2 13h7.2L3 8.1V10q0 .425-.288.713T2 11q-.425 0-.713-.288T1 10V6.15q0-.575.488-.863t.987-.012L13 11.05V5q0-.425.288-.713T14 4h3.075q.45 0 .85.188t.675.537l3.925 4.725q.225.275.35.6t.125.675V16q0 .425-.287.713T22 17h-1.5q0 1.25-.875 2.125T17.5 20q-1.25 0-2.125-.875T14.5 17H9q0 1.25-.875 2.125T6 20q-1.25 0-2.125-.875T3 17H2q-.425 0-.713-.288T1 16Zm5 2.5q.65 0 1.075-.425T7.5 17q0-.65-.425-1.075T6 15.5q-.65 0-1.075.425T4.5 17q0 .65.425 1.075T6 18.5Zm11.5 0q.65 0 1.075-.425T19 17q0-.65-.425-1.075T17.5 15.5q-.65 0-1.075.425T16 17q0 .65.425 1.075t1.075.425ZM15 10h5.4l-3.35-4H15v4Z" />
                    </svg>
                    <span> Drivers </span>
                </a>
            </li>
            @if (Auth::guard('administrator')->user()->role == 'superadmin')
                <li
                    class="side-nav-item {{ request()->is('administrator/dispatchers') || request()->is('administrator/dispatchers/*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('administrator.dispatchers.index') }}" class="side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                            <path fill="currentColor"
                                d="M16 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7zm10 28h-2v-5a5 5 0 0 0-5-5h-6a5 5 0 0 0-5 5v5H6v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7z" />
                        </svg>
                        <span> Dispatchers </span>
                    </a>
                </li>
                <li
                class="side-nav-item {{ request()->is('administrator/pages') || request()->is('administrator/pages/*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('administrator.pages.index') }}" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                        <path fill="currentColor"
                            d="M16 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7zm10 28h-2v-5a5 5 0 0 0-5-5h-6a5 5 0 0 0-5 5v5H6v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7z" />
                    </svg>
                    <span> Pages </span>
                </a>
            </li>
            @endif
            <li
                class="side-nav-item {{ request()->is('administrator/my-account') || request()->is('administrator/change-password/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false"
                    aria-controls="sidebarSettings" class="side-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m12 .845l9.66 5.578v11.154L12 23.155l-9.66-5.578V6.423L12 .845Zm0 2.31L4.34 7.577v8.846L12 20.845l7.66-4.422V7.577L12 3.155ZM12 9a3 3 0 1 0 0 6a3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0a5 5 0 0 1-10 0Z" />
                    </svg>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('administrator/my-account') || request()->is('administrator/change-password/*') || request()->is('administrator/leave-management/settings/*') ? 'show' : '' }}"
                    id="sidebarSettings">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('administrator.company-details.form') }}"><i
                                    class="dripicons-chevron-right me-1"></i>Company Details</a>
                        </li>
                        <li>
                            <a href="{{ route('administrator.password.form') }}"><i
                                    class="dripicons-chevron-right me-1"></i>Change Password</a>
                        </li>
                        <li>
                            <a href="{{ route('administrator.my-account.edit', Auth::guard('administrator')->id()) }}"><i
                                    class="dripicons-chevron-right me-1"></i>My
                                Account</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

</div>
