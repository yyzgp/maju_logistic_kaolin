 <!-- Topbar Start -->
 <div class="navbar-custom topnav-navbar topnav-navbar-light">
     <div class="container-fluid">
         <a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
             <div class="lines">
                 <span></span>
                 <span></span>
                 <span></span>
             </div>
         </a>
         <!-- LOGO -->
         <a href="" class="topnav-logo">
             <span class="topnav-logo-lg">
                 <img src="{{ asset('assets/images/logo/logo.png') }}" alt="" height="40">
             </span>
             <span class="topnav-logo-sm">
                 <img src="{{ asset('assets/images/logo/logo.png') }}" alt="" height="40">
             </span>
         </a>

         <ul class="list-unstyled topbar-menu float-end mb-0">

             <li class="dropdown notification-list">
                 <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                     id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                     @isset(Auth::guard('administrator')->user()->avatar)
                         <span class="account-user-avatar">
                             <img src="{{ asset('storage/uploads/administrator/' . Auth::guard('administrator')->user()->avatar) }}"
                                 alt="user-image" class="rounded-circle">
                         </span>
                     @else
                     @php
                        $lastname = Auth::guard('administrator')->user()->lastname ? Auth::guard('administrator')->user()->lastname[0] : Auth::guard('administrator')->user()->firstname[1];
                     @endphp
                         <span class="account-user-avatar">
                             <img src="https://placehold.co/150x150/D82D36/FFF?text={{ Auth::guard('administrator')->user()->firstname[0] }}{{ ucfirst($lastname) }}"
                                 alt="user-image" class="rounded-circle">
                         </span>
                     @endisset
                     <span>
                         <span class="account-user-name">{{ Auth::guard('administrator')->user()->firstname }}
                             {{ Auth::guard('administrator')->user()->lastname }}</span>
                         <span class="account-position">{{ ucfirst(Auth::guard('administrator')->user()->role) }}</span>
                     </span>
                 </a>
                 <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                     aria-labelledby="topbar-userdrop">

                     <a href="{{ route('administrator.password.form') }}" class="dropdown-item notify-item">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5"
                             stroke="currentColor" width="20" height="20" aria-hidden="true">
                             <path strokeLinecap="round" strokeLinejoin="round"
                                 d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                         </svg>
                         <span>Change Password</span>
                     </a>

                     <a href="{{ route('administrator.logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                         class="dropdown-item notify-item">
                         <svg class="filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-gray-500"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true" width="20" height="20">
                             <path fill-rule="evenodd"
                                 d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                 clip-rule="evenodd"></path>
                         </svg>
                         <span>Logout</span>
                     </a>
                     <form id="logout-form"
                         action="{{ 'App\Models\Administrator' == Auth::getProvider()->getModel() ? route('administrator.logout') : route('administrator.logout') }}"
                         method="POST" style="display: none;">
                         {{ csrf_field() }}
                     </form>

                 </div>
             </li>

         </ul>

     </div>
 </div>
 <!-- end Topbar -->
