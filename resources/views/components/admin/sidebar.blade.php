<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">


                <livewire:admin.admin-logo-component />


                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

                <li class="sidebar-item {{ request()->is('admin')  ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <!--  HOME -->
                <li class="sidebar-item  {{ request()->is('admin/home')  ? 'active' : '' }}">
                    <a href="{{ route('admin.home') }}" class='sidebar-link'>
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>


                <!--  PAGES -->
                <li class="sidebar-item has-sub {{ request()->is('admin/pages')  ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-regular fa-file-lines"></i>
                        <span>Pages</span>
                        &nbsp;<i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <!-- add active to submenu to be open by default -->
                    <ul class="submenu">
                        <li class="submenu-item {{ request()->is('admin/pages')  ? 'active' : '' }} ">
                            <a href="{{ route('admin.pages') }}" class='sidebar-link'>
                                <i class="fa-solid fa-file-lines"></i>
                                <span>List</span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/pages/create')  ? 'active' : '' }}">
                            <a href="{{ route('admin.page.create') }}" class='sidebar-link'>
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span>Create New</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--  BLOG -->
                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-brands fa-microblog"></i>
                        <span>Blog</span>
                        &nbsp;<i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <!-- add active to submenu to be open by default -->
                    <ul class="submenu">
                        <li class="submenu-item {{ request()->is('admin/posts')  ? 'active' : '' }} ">
                            <a href="{{ route('admin.blog') }}" class='sidebar-link'>
                                <i class="fa-solid fa-file-lines"></i>
                                <span>Blog Index</span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/posts')  ? 'active' : '' }} ">
                            <a href="{{ route('admin.posts') }}" class='sidebar-link'>
                                <i class="fa-solid fa-file-lines"></i>
                                <span>Posts</span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/post/create')  ? 'active' : '' }}">
                            <a href="{{ route('admin.post.create') }}" class='sidebar-link'>
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span>Create New</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- USERS -->
                <li class="sidebar-item  {{ request()->is('admin/users*')  ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class='sidebar-link'>
                        <i class="fa-solid fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>

                <!-- ROLES -->
                <li class="sidebar-item  {{ request()->is('admin/roles*')  ? 'active' : '' }}">
                    <a href="{{ route('admin.roles') }}" class='sidebar-link'>
                        <i class="fa-solid fa-user-lock"></i>
                        <span>Roles</span>
                    </a>
                </li>

                <!-- CONTACTS -->
                {{--
                <li class="sidebar-item  {{ request()->is('')  ? 'active' : '' }}">
                    <a href="" class='sidebar-link'>
                        <i class="fa-solid fa-rectangle-list"></i>
                        <span>Contacts</span>
                    </a>
                </li>
                --}}

                <!-- SETTINGS -->
                <li class="sidebar-item  {{ request()->is('admin/settings')  ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}" class='sidebar-link'>
                        <i class="fa-solid fa-gears"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <!-- MAINTENANCE MODE -->
                <li class="sidebar-item {{ request()->is('admin/maintenance') ? 'active' : '' }}">
                    <a href="{{ route('admin.maintenance')}}" class='sidebar-link'>
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span>Maintenance</span>
                    </a>
                </li>

                <!--  LOGOUT -->
                <li class="sidebar-item">
                    <a class="sidebar-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket text-danger"></i>
                        <span class="align-middle">Sign Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
