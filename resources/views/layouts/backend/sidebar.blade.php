<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="{{route('dashboard')}}">
                <span class="smini-visible">
                    T<span class="opacity-75">o</span>
                </span>
                <span class="smini-hidden">
                    Tow<span class="opacity-75">ards</span>
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </button>
                <!-- END Toggle Sidebar Style -->

                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <!-- END Dark Mode -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link {{ (request()->is('admin/dashboard') ? 'active' : '')}}  " href="{{route('dashboard')}}">
                        <i class="nav-main-link-icon fa fa-location-arrow"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>

                <li class="nav-main-heading ">Posts</li>
                <li class="nav-main-item {{ (request()->is('admin/blogs*') ? 'open' : '')}}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-thumbtack"></i>
                        <span class="nav-main-link-name">Posts</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('admin/blogs') ? 'active' : '')}}" href="{{route('blogs.index')}}">
                                <span class="nav-main-link-name">All Posts </span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link  {{ (request()->is('admin/blogs/create') ? 'active' : '')}} " href="{{route('blogs.create')}}">
                                <span class="nav-main-link-name">Add New </span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('admin/blogs/published') ? 'active' : '')}}" href="{{route('blogs.published')}}">
                                <span class="nav-main-link-name">Published</span>
                            </a>
                        </li>
                        <li class="nav-main-item ">
                            <a class="nav-main-link {{ (request()->is('admin/blogs/unpublished') ? 'active' : '')}}" href="{{route('blogs.unpublished')}}">
                                <span class="nav-main-link-name">Unpublished</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @can('view', request()->user())
                <li class="nav-main-heading ">Users</li>
                <li class="nav-main-item {{ (request()->is('admin/authors*') ? 'open' : '')}}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" href="#">
                        <i class="nav-main-link-icon fa fa-user"></i>
                        <span class="nav-main-link-name">Users</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('admin/authors') ? 'active' : '')}}" href="{{route('authors.index')}}">
                                <span class="nav-main-link-name">All Users </span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link  {{ (request()->is('admin/authors/create') ? 'active' : '')}} " href="{{route('authors.create')}}">
                                <span class="nav-main-link-name">Add New </span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endcan
                <li class="nav-main-heading ">Volumes</li>
                <li class="nav-main-item {{ (request()->is('admin/volumes*') ? 'open' : '')}}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-thumbtack"></i>
                        <span class="nav-main-link-name">Volumes</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('admin/volumes') ? 'active' : '')}}" href="{{route('volumes.index')}}">
                                <span class="nav-main-link-name">All Volumes </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
