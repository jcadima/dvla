<div class="dropdown">
    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-menu d-flex">
            <div class="user-name text-end me-3">
                <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                <p class="mb-0 text-sm text-gray-600">Administrator</p>
            </div>
            <div class="user-img d-flex align-items-center">
                <div class="avatar avatar-md">
                    <i class="fa-solid fa-circle-user fa-2xl"></i>
                </div>
            </div>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
        </li>
        <li><a class="dropdown-item" href="#">
                <i class="fa-solid fa-id-card"></i>
                Profile</a></li>
        <li><a class="dropdown-item" href="#">
                <i class="fa-solid fa-sliders"></i>
                Settings</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="p-4 text-danger text-decoration-none"
               href="{{ route('logout') }}"
               onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="align-middle">Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </li>
    </ul>
</div>
