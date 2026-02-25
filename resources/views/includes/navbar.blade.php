<nav class="navbar navbar-expand-md" aria-label="Fourth navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="https://kaolin.n2rdev.in/assets/images/logo/login-logo.png" class=""
        width="25%"></a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample04" style="">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active me-3" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route("about-us") }}">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-3" href="{{ route("contact-us") }}">Contact Us</a>
          </li>
        </ul>
        @if (Route::has('administrator.login'))
        @auth
            <a href="{{ url('/dashboard') }}" class="float-end btn btn-lg btn-danger mt-3">
                Dashboard
            </a>
        @else
            <a href="{{ route('administrator.login') }}" class="float-end btn btn-lg btn-danger mt-3">
                Log in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="float-end btn btn-lg btn-danger mt-3">
                    Register
                </a>
            @endif
        @endauth
    @endif
      </div>
    </div>
  </nav>
