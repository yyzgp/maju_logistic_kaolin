<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ route('index') }}" class="navbar-brand d-flex align-items-center ps-4">
        <img src="{{ asset("assets/images/logo/login-logo.png") }}" class="" width="21%">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('index') }}" class="nav-item nav-link active">Home</a>
            <a href="{{ route('about-us') }}" class="nav-item nav-link">About Us</a>

            <a href="{{ route('contact-us') }}" class="nav-item nav-link">Contact Us</a>
        </div>
        @if (Route::has('administrator.login'))
            @auth
                <a href="{{ route('administrator.dashboard') }}"
                    class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Dashboard<i
                        class="fa fa-arrow-right ms-3"></i></a>
            @else
                <a href="{{ route('administrator.login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i
                        class="fa fa-arrow-right ms-3"></i></a>
            @endauth
        @endif
    </div>
</nav>
<!-- Navbar End -->
