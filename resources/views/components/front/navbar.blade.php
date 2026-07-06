<nav class="navbar navbar-expand-lg fixed-top py-0 navbar-dark navbar-background">
    <div class="container-lg">
        <a class="navbar-brand py-2" href="{{ url('/') }}">
            <img src="{{ asset('images/dvla_logo_varB.svg') }}" alt="DVLA" class="dvla-nav-logo">
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dvlaNavbar" aria-controls="dvlaNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="dvlaNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('about-us') }}">About</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="https://github.com/jcadima/dvla" target="_blank">
                        <i class="fa-brands fa-github me-1"></i>GitHub
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-login-link" href="{{ route('login') }}">
                        <i class="fa-solid fa-terminal me-1"></i>Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
